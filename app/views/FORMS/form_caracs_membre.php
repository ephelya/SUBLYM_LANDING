            <div class='personnage tsujet hidden'>

                <div class="sujet desccivil">

                    <select name="age" class="prompt2  age">
                        <option value="">Âge</option>
                        <?php foreach ($age as $id => $objet) { echo "<option  data-poids='' data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="taille" class="prompt2  taille">
                        <option value="">Taille</option>
                        <?php foreach ($taille as $id => $objet) { echo "<option  data-poids=''  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="beaute" class="prompt2  beaute">
                        <option value="">Beauté</option>
                        <?php foreach ($beaute as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="corpulence" class="prompt2  corpulence">
                        <option value="">Corpulence</option>
                        <?php foreach ($corpulence as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_personnage" class="prompt2  type_personnage">
                        <option value="">Type de personnage</option>
                        <?php foreach ($type_personnage  as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="nationalite" class="prompt2  nationalite">
                        <option value="">Nationalité</option>
                        <?php foreach ($nationalite as $id => $objet) 
                        { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; 
                        } ?>
                    </select>
                    <select name="genre" class="prompt2  genre">
                        <option value="">Genre</option>
                        <?php foreach ($genre as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='sujet hair'>
                    <select name="barbe_moustache" class="prompt2  barbe_moustache">
                        <option value="">Barbe/Moustache</option>
                        <?php foreach ($barbe_moustache as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_cheveux" class="prompt2  type_cheveux">
                        <option value="">Type de cheveux</option>
                        <?php foreach ($type_cheveux as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="longueur_cheveux" class="prompt2  longueur_cheveux">
                        <option value="">Longueur des cheveux</option>
                        <?php foreach ($longueur_cheveux as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="couleur_cheveux" class="prompt2  couleur_cheveux">
                        <option value="">Couleur des cheveux</option>
                        <?php foreach ($couleur_cheveux as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="coiffure" class="prompt2  coiffure">
                        <option value="">Coiffure</option>
                        <?php foreach ($coiffure as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='sujet visage'>
                    <select name="couleur_peau" class="prompt2  couleur_peau">
                        <option value="">Couleur de peau</option>
                        <?php foreach ($couleur_peau as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="couleur_yeux" class="prompt2  couleur_yeux">
                        <option value="">Couleur des yeux</option>
                        <?php foreach ($couleur_yeux as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_bouche" class="prompt2  type_bouche">
                        <option value="">Type de bouche</option>
                        <?php foreach ($type_bouche as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_nez" class="prompt2  nez">
                        <option value="">Type de nez</option>
                        <?php foreach ($type_nez as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="forme_yeux" class="prompt2  forme_yeux">
                        <option value="">Forme des yeux</option>
                        <?php foreach ($forme_yeux as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='sujet attitude'>
                    <select name="position" class="prompt2">
                        <option value="">Position</option>
                        <?php foreach ($position as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="humeurs" class="prompt2  humeurs">
                        <option value="">Humeurs</option>
                        <?php foreach ($humeurs as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="expression" class="prompt2  expression">
                        <option value="">Expression</option>
                        <?php foreach ($expression as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="grossesse" class="prompt2  grossesse">
                        <option value="">Grossesse</option>
                        <?php foreach ($grossesse as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='sujet accessoires'>
                    <select name="lunettes" class="prompt2  lunettes">
                        <option value="">Lunettes</option>
                        <?php foreach ($lunettes as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="maquillage" class="prompt2  maquillage">
                        <option value="">Maquillage</option>
                        <?php foreach ($maquillage as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="tatouage" class="prompt2  tatouage">
                        <option value="">Tatouage</option>
                        <?php foreach ($tatouage as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="piercing" class="prompt2  piercing">
                        <option value="">Piercing</option>
                        <?php foreach ($piercing as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='sujet style'>
                    <select name="style_chaussures" class="prompt2  style_chaussures">
                        <option value="">Style de chaussures</option>
                        <?php foreach ($style_chaussures as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="style_vetements" class="prompt2  style_vetements">
                        <option value="">Style de vêtements</option>
                        <?php foreach ($style_vetements as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
                <div class='choose_vetement'>
                    <?php foreach ($vetements as $id => $objet) { 
                        echo "<input type='checkbox'   data-vet='".$objet->valeur."' id='".$objet->id."' name='vetement' value='".$objet->trad."' class='vetements'>";
                        echo "<label for='".$objet->trad."'>".$objet->valeur."</label>";
                        } ?>
                </div>
                <div class='sujet vetements'>
                    <select name="type_chemise" class="prompt2 hidden chemise">
                        <option value="">Type de chemise</option>
                        <?php foreach ($type_chemise as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_costume" class="prompt2 hidden costume">
                        <option value="">Type de costume</option>
                        <?php foreach ($type_costume as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_jupe" class="prompt2 hidden jupe">
                        <option value="">Type de jupe</option>
                        <?php foreach ($type_jupe as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_maillot_bain" class="prompt2 hidden maillot_bain">
                        <option value="">Type de maillot de bain</option>
                        <?php foreach ($type_maillot_bain as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_manteau" class="prompt2 hidden manteau">
                        <option value="">Type de manteau</option>
                        <?php foreach ($type_manteau as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_pantalon" class="prompt2 hidden pantalon">
                        <option value="">Type de pantalon</option>
                        <?php foreach ($type_pantalon as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_pull" class="prompt2 hidden pull">
                        <option value="">Type de pull</option>
                        <?php foreach ($type_pull as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_robe" class="prompt2 hidden robe">
                        <option value="">Type de robe</option>
                        <?php foreach ($type_robe as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_short" class="prompt2 hidden short">
                        <option value="">Type de short</option>
                        <?php foreach ($type_short as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_tshirt" class="prompt2 hidden tshirt">
                        <option value="">Type de t-shirt</option>
                        <?php foreach ($type_tshirt as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                    <select name="type_veste" class="prompt2 hidden veste">
                        <option value="">Type de veste</option>
                        <?php foreach ($type_veste as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
                    </select>
                </div>
            </div> <!-- // personnage -->