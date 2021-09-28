<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\AdresseType;
use App\Repository\AdresseTypeRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class ToolBox
{
    // use ControllerTrait;
    private $adresseTypeRepository;

    public function __construct(AdresseTypeRepository $adresseTypeRepository)
    {
        $this->adresseTypeRepository = $adresseTypeRepository;
    }


    public function getAdresses(User $user)
    {
        $adresses = [
            "domicile" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::DOMICILE, 'client' => $user->getClient()]),
            "livraison" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::LIVRAISON, 'client' => $user->getClient()]),
            "facturation" => $this->adresseTypeRepository->findOneBy(['typAdresse' => AdresseType::FACTURATION, 'client' => $user->getClient()])
        ];
        return $adresses;
    }

    public function getPanier(Session $session)
    {
        $panier = $session->get("panier");
        //$test = $panier[0]["id"];
        if ($panier == null) {
            return null; // 
        }

        if ($panier != null) {
            foreach ($panier as $i => $ligne) {
                $panier[$i]["prixTotal"] = $panier[$i]["quantite"] * $panier[$i]["prix"];
            }
        }
        if ($panier != null) {
            $commande = 0;
            foreach ($panier as $i => $ligne) {
                $commande = $commande + $panier[$i]["prixTotal"];
                $panier[0]["prixCommande"] = $commande;
            }
        }
        $session->set("panier", $panier);

        return $panier;
    }

    public function panierRaz(SessionInterface $session)
    {
        $session->remove("panier");
        $session->set("panier", []);
    }

    public function intervalCorrect($date, $nombreDeJourMax)
    {
        $maintenant = new DateTime();
        $maintenant->format("Y-m-d H:i:s");

        $dateCommande = DateTime::createFromFormat("Y-m-d H:i:s", $date->format("Y-m-d H:i:s"));    
        $intervalle = $dateCommande->diff($maintenant);

        if ($intervalle->format('%R') === "+" && ($intervalle->format('%d')*24+$intervalle->format('%h')) < $nombreDeJourMax) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Fonction qui permet de redimensionner une image en conservant les proportions
     * @param  string  $image_path Chemin de l'image
     * @param  string  $image_dest Chemin de destination de l'image redimentionnée (si vide remplace l'image envoyée)
     * @param  integer $max_size   Taille maximale en pixels
     * @param  integer $qualite    Qualité de l'image entre 0 et 100
     * @param  string  $type       'auto' => prend le coté le plus grand
     *                             'width' => prend la largeur en référence
     *                             'height' => prend la hauteur en référence
     * @param  boleen  $upload 	   true si c'est une image uploadée, false si c'est le chemin d'une image déjà sur le serveur
     * @return string              'success' => redimentionnement effectué avec succès
     *                             'wrong_path' => le chemin du fichier est incorrect
     *                             'no_img' => le fichier n'est pas une image
     *                             'resize_error' => le redimensionnement a échoué
     */
    public function resize_img($image_path,$image_dest,$max_size = 300,$qualite = 100,$type = 'auto',$upload = false){

        // Vérification que le fichier existe
        if(!file_exists($image_path)):
        return 'wrong_path';
        endif;
    
        if($image_dest == ""):
        $image_dest = $image_path;
        endif;
        // Extensions et mimes autorisés
        $extensions = array('jpg','jpeg','png','gif');
        $mimes = array('image/jpeg','image/gif','image/png');
    
        // Récupération de l'extension de l'image
        $tab_ext = explode('.', $image_path);
        $extension  = strtolower($tab_ext[count($tab_ext)-1]);
    
        // Récupération des informations de l'image
        $image_data = getimagesize($image_path);
    
        // Si c'est une image envoyé alors son extension est .tmp et on doit d'abord la copier avant de la redimentionner
        if($upload && in_array($image_data['mime'],$mimes)):
        copy($image_path,$image_dest);
        $image_path = $image_dest;
    
        $tab_ext = explode('.', $image_path);
        $extension  = strtolower($tab_ext[count($tab_ext)-1]);
        endif;
    
        // Test si l'extension est autorisée
        if (in_array($extension,$extensions) && in_array($image_data['mime'],$mimes)):
        
        // On stocke les dimensions dans des variables
        $img_width = $image_data[0];
        $img_height = $image_data[1];
    
        // On vérifie quel coté est le plus grand
        if($img_width >= $img_height && $type != "height"):
    
            // Calcul des nouvelles dimensions à partir de la largeur
            if($max_size >= $img_width):
            return 'no_need_to_resize';
            endif;
    
            $new_width = $max_size;
            $reduction = ( ($new_width * 100) / $img_width );
            $new_height = round(( ($img_height * $reduction )/100 ),0);
    
        else:
    
            // Calcul des nouvelles dimensions à partir de la hauteur
            if($max_size >= $img_height):
            return 'no_need_to_resize';
            endif;
    
            $new_height = $max_size;
            $reduction = ( ($new_height * 100) / $img_height );
            $new_width = round(( ($img_width * $reduction )/100 ),0);
    
        endif;
    
        // Création de la ressource pour la nouvelle image
        $dest = imagecreatetruecolor($new_width, $new_height);
    
        // En fonction de l'extension on prépare l'iamge
        switch($extension){
            case 'jpg':
            case 'jpeg':
            $src = imagecreatefromjpeg($image_path); // Pour les jpg et jpeg
            break;
    
            case 'png':
            $src = imagecreatefrompng($image_path); // Pour les png
            break;
    
            case 'gif':
            $src = imagecreatefromgif($image_path); // Pour les gif
            break;
        }
    
        // Création de l'image redimentionnée
        if(imagecopyresampled($dest, $src, 0, 0, 0, 0, $new_width, $new_height, $img_width, $img_height)):
    
            // On remplace l'image en fonction de l'extension
            switch($extension){
            case 'jpg':
            case 'jpeg':
                imagejpeg($dest , $image_dest, $qualite); // Pour les jpg et jpeg
            break;
    
            case 'png':
                $black = imagecolorallocate($dest, 0, 0, 0);
                imagecolortransparent($dest, $black);
    
                $compression = round((100 - $qualite) / 10,0);
                imagepng($dest , $image_dest, $compression); // Pour les png
            break;
    
            case 'gif':
                imagegif($dest , $image_dest); // Pour les gif
            break;
            }
    
            return 'success';
            
        else:
            return 'resize_error';
        endif;
    
        else:
        return 'no_img';
        endif;
    }

    public function image_resize($src, $dst, $width, $height, $crop=0){
        if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
      
        $type = strtolower(substr(strrchr($src,"."),1));
        if($type == 'jpeg') $type = 'jpg';
        switch($type){
          case 'bmp': $img = imagecreatefromwbmp($src); break;
          case 'gif': $img = imagecreatefromgif($src); break;
          case 'jpg': $img = imagecreatefromjpeg($src); break;
          case 'png': $img = imagecreatefrompng($src); break;
          default : return "Unsupported picture type!";
        }
      
        // resize
        if($crop){
          if($w < $width or $h < $height) return "Picture is too small!";
          $ratio = max($width/$w, $height/$h);
          $h = $height / $ratio;
          $x = ($w - $width / $ratio) / 2;
          $w = $width / $ratio;
        }
        else{
          if($w < $width and $h < $height) return "Picture is too small!";
          $ratio = min($width/$w, $height/$h);
          $width = $w * $ratio;
          $height = $h * $ratio;
          $x = 0;
        }
      
        $new = imagecreatetruecolor($width, $height);
      
        // preserve transparency
        if($type == "gif" or $type == "png"){
          imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
          imagealphablending($new, false);
          imagesavealpha($new, true);
        }
      
        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
      
        switch($type){
          case 'bmp': imagewbmp($new, $dst); break;
          case 'gif': imagegif($new, $dst); break;
          case 'jpg': imagejpeg($new, $dst); break;
          case 'png': imagepng($new, $dst); break;
        }
        return true;
      }

    public function imageResizer($fileName, $dest, $width = 100, $square = true)
    {
        // Exemple de chemin vers public avec symfony :
        // Injecter : ParameterBagInterface $parameterBagInterface
        // $chemin = $parameterBagInterface->get('kernel.project_dir').'/public/images/produit/';

        $img = new \Imagick($fileName);
        $w = $img->getImageWidth();
        $h = $img->getImageHeight();
        // On doit redimensionner
        if ($w>$width || $h>$width) {
            if ($w>$h) {
                $img->thumbnailImage($width, 0);
            }
            else {
                $img->thumbnailImage(0, $width);
            }
            if ($square) {
                // Si le format est carré, on applique des marge horizontales ou verticales
                $w = $img->getImageWidth();
                $h = $img->getImageHeight();
                $canvas = new \Imagick();
                $canvas->newImage($width, $width, 'white', $img->getImageFormat() );
                $offsetX = (int)($width  / 2) - (int)($w  / 2);
                $offsetY = (int)($width / 2) - (int)($h / 2);
                $canvas->compositeImage( $img, \Imagick::COMPOSITE_OVER, $offsetX, $offsetY );
                $canvas->writeImage($dest);
                return;
            }
            $img->writeImage($dest);
        }
    }
}
