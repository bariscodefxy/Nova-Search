<?php
require 'baglan.php';

if(isset($_POST['a'])){
    $ad = $_POST['a_adi'];
    $site = $_POST['a_site'];
    $resim = $_POST['a_resim'];
    $aciklama = $_POST['a_aciklama'];
    $yas = $_POST['a_yas'];
    $link = $_POST['a_link'];
    $kullanici = $_SESSION['isim'];

    $EmailSay = $db->prepare("SELECT * FROM tarayici_card_anime_users WHERE user_card_title = ? OR user_card_text = ?");
    $EmailSay->execute(array($ad, $aciklama));
    $kontrol = $EmailSay->fetch(PDO::FETCH_ASSOC);
    if($kontrol > 0)
    {
        echo '
                <div class="alert alert-warning alert-dismissible fade show col-md-12" role="alert">
                  <strong>Dikkat!</strong> Girmiş olduğunuz Anime kayıtlıdır.
                  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>';
    } else{
        try {
            $sorgu = $db ->prepare('INSERT INTO tarayici_card_anime_users (user_card_title, user_card_muted, user_card_text, user_card_image, user_card_link, user_card_name, user_card_username) VALUES (?,?,?,?,?,?,?)');
            $ekle = $sorgu ->execute([
               $ad, $yas, $aciklama, $resim, $link, $site, $kullanici
            ]);
        }catch (Exception $e){
            echo $e->getMessage();
        }
        if ($ekle) {
            echo '
                <div class="alert alert-info alert-dismissible fade show col-md-12" role="alert">
                  Girmiş olduğunuz anime <strong>Başarlıyla</strong> Eklenmiştir...
                  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>';
            echo '<meta http-equiv="refresh" content="3;url=index.php">';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
                  <strong>Hata!</strong> Beklenmedik bir hata meydana geldi lütfen daha sonra tekrar deneyin.
                  <button type="button" class="btn-close" data-mdb-dismiss="alert" aria-label="Close"></button>
                </div>';
        }
    }

}
