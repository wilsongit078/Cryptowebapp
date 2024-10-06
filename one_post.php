 
<div class="post-content" style = "margin-top:5px;"id = "story" daa-aos = "zoom-in" daa-aos-delay="200">
    
    
    <div id ="" class="post-image">
        <div id="post_user">
        
                <?php


                $image = "assets/user.png";

            
                
                
                if (file_exists($ROW_USER['profile_image']))
                {
                    $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
                }

                ?>

                <img src= "<?php echo $image ?>" style = "width:75px; margin-right:4px;border-radius:50%" >
                <div style ="font-weight:bold; color: #405d9d; width:100%;font-family: var(--Livvic);">

                    <?php
                    $you = "";
                    if($_SESSION['blooger_userid'] == $ROW_USER['userid']){
                        $you = " ( You )";
                    } 
                    echo "<a href = 'profile.php?id=$ROW[userid]'>";
                    echo htmlspecialchars($ROW_USER['username']) . $you;
                    
                    echo "</a>";

                    echo   "<br> " . $time_class->get_time($ROW['date']);
                ?>
                </div>

            </div>
        <div id = "<?php echo  $ROW['postid']; ?>" id = "post-image" >

            
            
            <?php
            if(file_exists($ROW['image']))
            {
                $post_image = $image_class->get_thumb_post($ROW['image']);
                echo '
                <a href="image_view.php?id='. $ROW["postid"]. '">
                    <img src="' . $post_image . '" class="img" id = "post-image" alt="post" style = "" >
                </a>
                ';
            }
    
            ?>
            
        </div>
       
    </div>
    <div class="post-tittle">
      
        <a href="one_blog.php?id=<?php echo $ROW['postid'] ?>">
            <?php
            $title = $ROW['title'];
            $id = $ROW['postid'];
             echo htmlspecialchars( $title ." ( ". $ROW['blogtype'] . " ) ") ;
             ?> 
        </a>
        <div class ="paragraph <?php echo $overflow?>" class = " flex-row" >
            <?php
 
               // echo wordwrap("<p style = 'font-size: .85rem;'>" . htmlspecialchars($ROW['post']) ."</p>", 520,"<br><br>\n", false);
                echo "<p>" . nl2br(htmlspecialchars($ROW['post'])) . "</p>";
            ?>
             
        </div>
        <?php 
             if(strlen($overflow) > 0){
                echo'
                    <a href = "one_blog.php?id='. $ROW['postid'] .'"><button class="btn post_btn" id = "post_btn">Read More &nbsp; <i class="fas fa-arrow-right"></i></button></a>
                     
                ';
            }
        ?>
        <br><br>
        <div class = "flex-row">
        <div id = "post_btn">

            <?php
                $likes = "";
                $likes = ($ROW['likes'] > 0) ? $ROW['likes'] . " " : "" ;
            ?>
            
            <span>
            <a id = 'like_<?php echo $ROW['postid'];?>' onclick = "like_post(event, href)" id = "#check" href = "like.php?type=post&id=<?php echo  $ROW['postid']; ?>"><?php echo $likes ?><i class='fas fa-thumbs-up'></i></a>
            </span>
             
        </div>
        &nbsp;&nbsp;
        <div id = "post_btn">
            <?php

            $comments = "";
            if ($ROW['comments'] > 0) {
                $comments = $ROW['comments'] . " ";
            }
            ?>
            <span>
                <a id = "check" href = "one_blog.php?id=<?php echo $ROW['postid'] ?>"><?php echo $comments ?><i class="fas fa-comment"></i></a>
            </span>
             
        </div>
        &nbsp;&nbsp;
        <div id = "post_btn">
            <?php

                $shares = "";
                if ($ROW['shares'] > 0) {
                    $shares = $ROW['shares'] . " ";
                }
            
                
                 //include("share.php");
            ?>
                    
                <span class = "shareButton" data-id = "<?php echo $ROW['postid']; ?>" >
                    

                    <a id = "#check" onclick = "share_post(event, href)" href = "like.php?type=post&id=<?php echo  $ROW['postid']; ?>"><?php //echo $shares ?><i class="fas fa-share"></i></a>
                
                     
                </span>
       
        </div>
              
        </div> <br>
         <div id = "comment_info">
            <span style="color:#999; float: right;">
             
                <?php
    
                    $post = new Post();
    
                    if($post->i_own_post($ROW['postid'], $_SESSION['blooger_userid'])){
    
                        echo "
                        <a id = 'post_details' href ='edit.php?id=$ROW[postid]'>
                            Edit
                        </a>.
                        <a id = 'post_details' href ='delete.php?id=$ROW[postid]'>
                            Delete
                        </a>";
                    
                    }
    
                ?>
            </span>
    
                <?php 
                $i_liked = false;
                if(isset($_SESSION['blooger_userid'])) {
    
                
                        $DB = new Database();
                        $sql = "select likes from likes where type ='post' && contentid = '$ROW[postid]' limit 1";
                        
                        
    
                       $result = $DB->read($sql);
                       
    
                        if(is_array($result)){
    
                            $likes = json_decode($result[0]['likes'], true);
    
                            $user_ids  = array_column($likes, "userid");
                            if(in_array($_SESSION['blooger_userid'], $user_ids)){
                                $i_liked = true;
                            }
                        }
    
                    }
    
                                echo "<a id = 'info_$ROW[postid]' id = 'post_details' href='likes.php?type=post&id=$ROW[postid]'>";
                        
                    if($ROW['likes'] > 0){
            
    
                        //echo "<br>";
                         if($ROW['likes'] == 1){
                            if($i_liked){
                                echo "<div   style = 'text-align: left;'>You liked this post.</div>";
                            }else{
                            
                                echo "<div style = 'text-align: left;'>1 person liked this post.</div>";
                            }
                        }else{
    
    
                            if($i_liked){
                                $text = "others";
                                if($ROW['likes'] -1 == 1){
                                    $text = "other";
                                }
    
                                echo "<div style = 'text-align: left;'>You and " . ($ROW['likes'] -1) . " $text liked this post.</div>";
                            
                            }else{
                            echo "<div style = 'text-align: left;'>" . $ROW['likes'] . " people liked this post.</div>";
                        
                            }
                        
                        }
    
                        
                      
                    }
                      echo "</a>";
                ?>
         </div>
    </div>
<br> <br></div>
<hr data-aos = "fade-right" data-aos-delay="200">
 
 <script>

function ajax_send(data,element) {

     
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('readystatechange', function(){
        if(ajax.readyState == 4 && ajax.status == 200){
            response(ajax.responseText,element);
            
        }
    });

    
    
    data = JSON.stringify(data);
    ajax.open("post","ajax.php",true);
    ajax.send(data);
}

function response(result,element){
//alert(result);
      
    if(result != "")
    {
       var obj = JSON.parse(result);
       if(typeof obj.action != "undefined"){
            
            if(obj.action =="like_post"){
                
                var like_element = document.getElementById("like_" + obj.e_id);
                //
                var likes = "";

//alert(like_element)
                likes = (parseInt(obj.likes) > 0) ? obj.likes + " <i class='fas fa-thumbs-up'></i>" : "<i class='fas fa-thumbs-up'></i>" ;
                like_element.innerHTML = likes;
                //likes = "";
                var info_element = document.getElementById(obj.id);
                
                info_element.innerHTML = obj.info;
            }
            if(obj.action =="like_comment"){
                
                var like_element = document.getElementById("like_" + obj.e_id);
                
                var likes = "";


                likes = (parseInt(obj.likes) > 0) ? obj.likes + " Like" : "Like" ;
                like_element.innerHTML = likes;
                //likes = "";
                
                var info_element = document.getElementById(obj.id);
                //alert(info_element);
                info_element.innerHTML = obj.info;
            }
            if(obj.action =="share_post"){

               // var img = fetchImageAsBlob(obj.img);
               // const filesArray = [new File([img], obj.image, { type: img.type })];
              
               // Fetch the image from the server
                //const response = fetch(obj.img);
               // const blob = response.blob();

                // Create a File object from the blob
                const img = obj.img;
               var topic = obj.topic;
                var desc = obj.desc;
                var link = obj.link;
                share_menu(img, topic, desc, link);
                 
            }
       }
        
    }
    
}
function like_post(e, element){
    e.preventDefault();

    var link = e.target.href;
        if(link = "undefined"){
            link = element;
        } else{
            link = e.target.href;
        }
    var data = {};
    data.link = link; 
    data.action = "like_post";
    ajax_send(data, e.target);
    //share_menu();
}
function like_comment(e, element){
    e.preventDefault();

    var link = e.target.href;
        if(link = "undefined"){
            link = element;
        } else{
            link = e.target.href;
        }
    var data = {};
    data.link = link; 
    data.action = "like_comment";
    ajax_send(data, e.target);
    //share_menu();
}
function share_post(e, element){
    e.preventDefault();

    var link = e.target.href;
        if(link = "undefined"){
            link = element;
        } else{
            link = e.target.href;
        }
    var data = {};
    data.link = link; 
    data.action = "share_post";
     
    ajax_send(data, e.target);
    
}

function fetchImageAsBlob(imageUrl) {
    fetch(imageUrl)
        .then(response => response.blob())
        .then(blob => {
            // Do something with the blob, e.g., create an object URL
            const objectURL = URL.createObjectURL(blob);
            console.log(objectURL);
            return objectURL;
            // You can now use this object URL in your application
        })
        .catch(error => {
            console.error('Error fetching image:', error);
        });
}
async function ishare_menu(imageUrl, desc, link) {
      if (navigator.share) {
          try {
                // Fetch the image with a timeout to avoid long waits
                      const controller = new AbortController();
                            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 seconds timeout

                                  const response = await fetch(imageUrl, { signal: controller.signal });
                                        clearTimeout(timeoutId);

                                              if (!response.ok) throw new Error('Network response was not ok');

                                                    const blob = await response.blob();
                                                          const imageFile = new File([blob], 'shared-image.jpg', { type: blob.type });

                                                                // Create a text file from the description and link
                                                                      const textContent = `${link}`;
                                                                            const textBlob = new Blob([textContent], { type: 'text/plain' });
                                                                                  const textFile = new File([textBlob], 'shared-text.txt', { type: 'text/plain' });

                                                                                        const shareData = {
                                                                                                files: [imageFile, textFile],
                                                                                                       // url: link
                                                                                                              };

                                                                                                                    await navigator.share(shareData);
                                                                                                                          console.log('Successful share');
                                                                                                                              } catch (error) {
                                                                                                                                    console.log('Error sharing', error);
                                                                                                                                        }
                                                                                                                                          } else {
                                                                                                                                              console.log('Web Share API not supported.');
                                                                                                                                                }
                                                                 

}
async function share_menu(imageUrl, topic, desc, link) {
  if (navigator.share) {
    try {
      // Fetch the image with a timeout to avoid long waits
      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 seconds timeout

      const response = await fetch(imageUrl, { signal: controller.signal });
      clearTimeout(timeoutId);

      if (!response.ok) throw new Error('Network response was not ok');

      const blob = await response.blob();
      const file = new File([blob], 'shared-image.jpg', { type: blob.type });

      const shareData = {
        text: desc,//`${topic}\n\n${desc}`,
//files: [file],
                url: link
        
      };

      // Attempt to share the data
      await navigator.share(shareData);
      console.log('Successful share');
    } catch (error) {
      console.log('Error sharing', error); alert(error);
    }
  } else {
    console.log('Web Share API not supported.');
  }
}

               /* */
                    
</script>
