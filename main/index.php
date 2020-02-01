<?php

//returns a big old hunk of JSON from a non-private IG account page.
function scrape_insta($username) {
	$insta_source = file_get_contents('http://instagram.com/'.$username);
	$shards = explode('window._sharedData = ', $insta_source);
	$insta_json = explode(';</script>', $shards[1]); 
	$insta_array = json_decode($insta_json[0], TRUE);
	return $insta_array;
}

//Supply a username
$username = 'firmanjl363'; 

//Do the deed
$results_array = scrape_insta($username)['entry_data']['ProfilePage'][0]['graphql']['user'];

$linkAccount = 'http://instagram.com/'.$username;
$fullname = $results_array['full_name'];
$listPost = $results_array['edge_owner_to_timeline_media']['edges'];
$profile_pic = $results_array['profile_pic_url_hd'];
$follower = $results_array['edge_followed_by']['count'];
$following = $results_array['edge_follow']['count'];
$countPost = $results_array['edge_owner_to_timeline_media']['count'];
$biography = $results_array['biography'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile | Vietgram</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <nav class="navigation">
        <div class="navigation__column">
            <a href='http://instagram.com/'>
                <img src="images/logo.png" />
            </a>
        </div>
        <!-- <div class="navigation__column">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search">
        </div> -->
        <div class="navigation__column">
            <ul class="navigations__links">
                <!-- <li class="navigation__list-item">
                    <a href="explore.html" class="navigation__link">
                        <i class="fa fa-compass fa-lg"></i>
                    </a>
                </li>
                <li class="navigation__list-item">
                    <a href="#" class="navigation__link">
                        <i class="fa fa-heart-o fa-lg"></i>
                    </a>
                </li> -->
                <li class="navigation__list-item">
                    <a href="<?=$linkAccount?>" class="navigation__link" target="_blank" rel="noopener">
                        <i class="fa fa-user-o fa-lg"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <main id="profile">
        <header class="profile__header">
            <div class="profile__column">
                <img src="<?=$profile_pic?>" width="150px" />
            </div>
            <div class="profile__column">
                <div class="profile__title">
                    <h3 class="profile__username"><?=$username?></h3>
                    <!-- <a href="edit-profile.html">Edit profile</a> -->
                    <!-- <i class="fa fa-cog fa-lg"></i> -->
                </div>
                <ul class="profile__stats">
                    <li class="profile__stat">
                        <span class="stat__number"><?=$countPost?></span> posts
                    </li>
                    <li class="profile__stat">
                        <span class="stat__number"><?=$follower?></span> followers
                    </li>
                    <li class="profile__stat">
                        <span class="stat__number"><?=$following?></span> following
                    </li>
                </ul>
                <p class="profile__bio">
                    <span class="profile__full-name">
                        <?=$fullname?>
                        <br>
                    </span> 
                    <textarea id="bio" name="" id="" cols="30" rows="10"><?=$biography?></textarea>
                </p>
            </div>
        </header>
        <section class="profile__photos">
            <?php
            foreach ($listPost as $key => $value):
            ?>
                <div class="profile__photo">
                <div style="background-image:url('<?=$value['node']['display_url']?>'); background-size: 100%; height: 290px; width: 290px; background-position:center;">&nbsp;</div>
                    <div class="profile__photo-overlay">
                        <span class="overlay__item">
                            <i class="fa fa-heart"></i>
                            <?=$value['node']['edge_liked_by']['count']?>
                        </span>
                        <span class="overlay__item">
                            <i class="fa fa-comment"></i>
                            <?=$value['node']['edge_media_to_comment']['count']?>
                        </span>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </section>
    </main>
    <footer class="footer">
        <div class="footer__column">
            <nav class="footer__nav">
                <ul class="footer__list">
                    <li class="footer__list-item"><a href="#" class="footer__link">About Us</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Support</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Blog</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Press</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Api</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Jobs</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Privacy</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Terms</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Directory</a></li>
                    <li class="footer__list-item"><a href="#" class="footer__link">Language</a></li>
                </ul>
            </nav>
        </div>
        <div class="footer__column">
            <span class="footer__copyright">© 2020 Instagram</span>
        </div>
    </footer>
</body>

</html>