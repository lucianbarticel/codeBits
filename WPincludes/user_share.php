<div class="articleShare">
    <div class="PostSocial">
        <div class="postSocialContent">
        <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

            <?php if(!empty($data['show_facelikebtn'])) { ?>
                <span class="socialBtn"> <iframe src="//www.facebook.com/plugins/like.php?locale=en_US&href=<?php echo $actual_link; ?>&amp;send=false&amp;layout=button_count&amp;width=70&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=62" scrolling="no" frameborder="0" style="border:none; overflow:hidden; margin: auto; width: 80px; height:25px;" allowTransparency="true"></iframe></span>
            <?php } ?>

            <?php if(!empty($data['show_twittbtn'])) { ?>
                <span class="socialBtn"><a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="<?php echo $data['twittbtnname']; ?>" data-related="Lioit:Advanced Web Solutions">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script></span>
            <?php } ?>
            <?php if(!empty($data['show_diggshare'])) { ?>
                <span class="socialBtn"><script type="text/javascript">
                        (function() {
                            var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
                            s.type = 'text/javascript';
                            s.async = true;
                            s.src = 'http://widgets.digg.com/buttons.js';
                            s1.parentNode.insertBefore(s, s1);
                        })();
                    </script>
                                    <a style="" class="DiggThisButton DiggCompact"></a>
                                      </span>
            <?php } ?>
            <?php if(!empty($data['show_gplusbtn'])) { ?>
                <span class="socialBtn">
                                    <g:plusone size="medium" annotation="none"></g:plusone>
                                    <script type="text/javascript">
                                        window.___gcfg = {lang: 'ar'};
                                        (function() {
                                            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                            po.src = 'https://apis.google.com/js/plusone.js';
                                            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                        })();
                                    </script>
                                      </span>
            <?php } ?>





        </div>
    </div>
</div><!--End ArticleSahre-->