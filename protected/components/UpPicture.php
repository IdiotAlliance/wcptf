<?php
/**
 * @author luwenbin
 * 图片上传组件 
 * pic_path指图片上传路径，如“upload/cover/”
 * name指页面input框的name值
 */
class UpPicture
{
    public static function uploadPicture($pic_path,$name){
        $arr = UpPicture::handleUpload($pic_path, $name);
        echo json_encode($arr);
        return $arr['pid'];
    }

    public static function uploadPictureWithoutEcho($pic_path,$name){
        return UpPicture::handleUpload($pic_path, $name);
    }

    private static function handleUpload($pic_path,$name){
        $picname = $_FILES[$name]['name'];
        $picsize = $_FILES[$name]['size'];
        if ($picname != "") {
            if ($picsize > 4096000) {
                throw new CHttpException(403, '图片大小不能超过1M');
                exit;
            }
            preg_match('/.*(\.jpg|\.JPG|\.png|\.PNG)$/i', $picname, $matches);
            $type = $matches[1];
            
            if ($type != ".png" && $type != ".jpg" && $type != ".PNG" && $type != ".JPG") {
                throw new CHttpException(403, '图片格式不对！');
                exit;
            }
            $rand = rand(100, 999);
            $pics = date("YmdHis") . $rand . $type;
            //上传路径
            UpPicture::getFolder($pic_path);
            $pic_path = $pic_path.Yii::app()->user->sellerId.'/'. $pics;
            move_uploaded_file($_FILES[$name]['tmp_name'], $pic_path);
            $picture = new PicturesAR;
            $picture->seller_id = Yii::app()->user->sellerId;
            $picture->pic_url = $pic_path;
            $picture->name = $picname;
            $picture->save();
        }
        $size = round($picsize/1024,2);
        $arr = array(
            'pid'=>$picture->id,
            'name'=>$picname,
            'pic_path'=>$pic_path,
            'size'=>$size
        );
        return $arr;
    }

    /**
     * 按照用户id创建存储文件夹
     * @return string
     */
    public static function getFolder($pathStr)
    {
        if ( strrchr( $pathStr , "/" ) != "/" ) {
            $pathStr .= "/";
        }
        $pathStr .= Yii::app()->user->sellerId;
        if ( !file_exists( $pathStr ) ) {
            if ( !mkdir( $pathStr) ) {
                return false;
            }
        }
    }
}