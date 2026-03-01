<?php
require __DIR__ . '/../config.php';

$posts = $conn->query("SELECT * FROM posts WHERE status='pending'");
while($post = $posts->fetch_assoc()){
    $post_id = $post['id'];
    $targets = $conn->query("SELECT * FROM post_targets WHERE post_id=$post_id AND status='pending'");

    while($target = $targets->fetch_assoc()){
        $platform = $target['platform'];

        // Fetch access token
        $stmt = $conn->prepare("SELECT * FROM connected_accounts WHERE user_id=? AND platform=?");
        $stmt->bind_param("is", $post['user_id'], $platform);
        $stmt->execute();
        $res = $stmt->get_result();
        $account = $res->fetch_assoc();
        if(!$account){ 
            $conn->query("UPDATE post_targets SET status='error', error='No account connected' WHERE id=".$target['id']); 
            continue; 
        }

        $video_file = "../uploads/".$post['video_path'];
        $caption = $post['caption'];

        // ------------------ YouTube ------------------
        if($platform==='youtube'){
            $access_token = $account['access_token'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/upload/youtube/v3/videos?part=snippet,status");
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
            curl_setopt($ch, CURLOPT_POST, 1);
            $snippet = json_encode([
                "snippet"=>["title"=>$caption,"description"=>$caption],
                "status"=>["privacyStatus"=>"private"]
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['snippet'=>$snippet,'video'=>new CURLFile($video_file)]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
            curl_close($ch);
            $conn->query("UPDATE post_targets SET status='completed', platform_post_id='youtube' WHERE id=".$target['id']);
        }

        // ------------------ Instagram ------------------
        elseif($platform==='instagram'){
            $access_token = $account['access_token'];
            $ch = curl_init("https://graph.facebook.com/v17.0/me/media");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'media_type' => 'VIDEO',
                'video_url' => 'https://YOURDOMAIN.com/uploads/'.$post['video_path'], // Must be public URL
                'caption' => $caption,
                'access_token' => $access_token
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if(isset($response['id'])){
                // Publish container
                $media_id = $response['id'];
                $ch2 = curl_init("https://graph.facebook.com/v17.0/me/media_publish");
                curl_setopt($ch2, CURLOPT_POST, 1);
                curl_setopt($ch2, CURLOPT_POSTFIELDS, [
                    'creation_id' => $media_id,
                    'access_token' => $access_token
                ]);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch2);
                curl_close($ch2);
                $conn->query("UPDATE post_targets SET status='completed', platform_post_id='$media_id' WHERE id=".$target['id']);
            } else {
                $conn->query("UPDATE post_targets SET status='error', error='".json_encode($response)."' WHERE id=".$target['id']);
            }
        }

        // ------------------ Facebook ------------------
        elseif($platform==='facebook'){
            $access_token = $account['access_token'];
            $page_id = 'me'; // Or saved page ID
            $ch = curl_init("https://graph.facebook.com/v17.0/$page_id/videos");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                'description' => $caption,
                'source' => new CURLFile($video_file),
                'access_token' => $access_token
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($response['id'])){
                $conn->query("UPDATE post_targets SET status='completed', platform_post_id='".$response['id']."' WHERE id=".$target['id']);
            } else {
                $conn->query("UPDATE post_targets SET status='error', error='".json_encode($response)."' WHERE id=".$target['id']);
            }
        }

        // ------------------ TikTok ------------------
        elseif($platform==='tiktok'){
            $access_token = $account['access_token'];
            // Step 1: Upload video to TikTok server
            $ch = curl_init("https://open-api.tiktok.com/video/upload/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['video' => new CURLFile($video_file)]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($response['data']['video_id'])){
                $video_id = $response['data']['video_id'];
                // Step 2: Publish video
                $ch2 = curl_init("https://open-api.tiktok.com/video/publish/");
                curl_setopt($ch2, CURLOPT_POST, 1);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, ["Authorization: Bearer $access_token"]);
                curl_setopt($ch2, CURLOPT_POSTFIELDS, ['video_id'=>$video_id,'text'=>$caption]);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_exec($ch2);
                curl_close($ch2);
                $conn->query("UPDATE post_targets SET status='completed', platform_post_id='$video_id' WHERE id=".$target['id']);
            } else {
                $conn->query("UPDATE post_targets SET status='error', error='".json_encode($response)."' WHERE id=".$target['id']);
            }
        }

    } // end targets loop

    $conn->query("UPDATE posts SET status='completed' WHERE id=$post_id");
}
?>