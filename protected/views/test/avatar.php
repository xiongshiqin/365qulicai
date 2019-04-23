<div class="w800 fr">
            <span style="display:none">
            	<img src="<?php echo HComm::avatarpath(Yii::app()->user->id, 'm');?>" id="hideImg" onload="getUserImg()" onerror="">
            </span>
        	<div class="info-main">
                <div class="info-title mb10">
                    <h3>修改头像</h3>                    
                </div>
                <p class="mb20">上传一张图片作为自己的个人头像。上传完成后，请<span class="c-red">刷新</span>页面显示新头像</p>
                <p><img src="<?php echo HComm::avatar(Yii::app()->user->id, 'm'); ?>" id="userImage"/></p>
                <?php echo $urlCameraFlash; ?>
            </div>
        </div>