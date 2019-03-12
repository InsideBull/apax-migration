<?php global $IS_EXPORT; ?>
<div class="chiffre-cle" style="color:<?= $chiffre_cle["chiffre_cle_couleur_chiffre"]?>; background-color:<?= ($chiffre_cle["chiffre_cle_couleur_fond"]?$chiffre_cle["chiffre_cle_couleur_fond"]:'rgba(0,0,0,0)')?>">
		<?= $chiffre_cle["chiffre_cle_prefixe"] ?><div class="num animated-number" <?= (!$IS_EXPORT && $chiffre_cle["chiffre_cle_animer"]?'data-stats="'.$chiffre_cle["chiffre_cle_chiffre"].'"':"") ?>><?= (!$IS_EXPORT && $chiffre_cle["chiffre_cle_animer"]?"0":$chiffre_cle["chiffre_cle_chiffre"]) ?></div><?= $chiffre_cle["chiffre_cle_suffixe"]?>
		<div class="text" style="color:<?= $chiffre_cle["chiffre_cle_couleur_texte"]?>"><?= $chiffre_cle["chiffre_cle_text"]?></div>
	</div>
