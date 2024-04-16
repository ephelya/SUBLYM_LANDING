<select name="bucketlist" class="prompt3 bucketlist">
<option value="">Bucketlist</option>
<?php foreach ($bucketlist as $id => $objet) { echo "<option  data-poids=''  data-prompt='".$objet->trad."' value='".$objet->id."'>".$objet->valeur."</option>"; } ?>
</select>
<input type='text' class='searchbucket' placeholder='Chercher...'>