<?php
?>
<h2 class="itinerary-options-title">Mes options de cout</h2>

<div class="itinerary-options itinerary-options-myvehicle clearfx">
<label>Ma voiture</label>
<button type="button" class="add-car">Ajouter ma voiture</button>
<button type="button" class="remove-car close" title="Supprimer"></button>
<div class="user-car"></div>
</div>

<div class="itinerary-options itinerary-options-SELECT itinerary-options-car clearfx">
<div class="enhance-SELECT-container" data-view="shared/SELECT" data-label="itinerary_form_options_car_label" data-translation_prefix="itinerary_form_options_car_" data-SELECT_name="car" data-_block="        hatchback
        compact
        family
        sedan
        luxury
">  <label for="car">Type de voiture</label>
<SELECT name="car"><option value="hatchback" >Citadine</option>
<option value="compact" >Compacte</option>
<option value="family" >Familiale</option>
<option value="sedan" >Routière</option>
<option value="luxury" >Luxe</option></SELECT>
<div class="toggle-enhance-SELECT truncate" tabindex="-1">
<span class="SELECT-placeholder">Citadine</span>
<svg class="icon icon-dropdown"><use xlink:href="#icon-dropdown"></use></svg>
</div>
<ul class="enhance-SELECT"><li data-value="hatchback" class="truncate" title="Citadine">Citadine</li>
<li data-value="compact" class="truncate" title="Compacte">Compacte</li>
<li data-value="family" class="truncate" title="Familiale">Familiale</li>
<li data-value="sedan" class="truncate" title="Routière">Routière</li>
<li data-value="luxury" class="truncate" title="Luxe">Luxe</li></ul></div></div>

<div class="itinerary-options itinerary-options-SELECT itinerary-options-fuel clearfx">
<div class="enhance-SELECT-container" data-view="shared/SELECT" data-label="itinerary_form_options_fuel_label" data-translation_prefix="itinerary_form_options_fuel_" data-SELECT_name="fuel" data-_block="        petrol
        diesel
        lpg
        electric
">  <label for="fuel">Type de carburant</label>
<SELECT name="fuel"><option value="petrol" >Essence</option>
<option value="diesel" >Diesel</option>
<option value="lpg" >GPL</option>
<option value="electric" >Electrique</option></SELECT>
<div class="toggle-enhance-SELECT truncate" tabindex="-1">
<span class="SELECT-placeholder">Essence</span>
<svg class="icon icon-dropdown"><use xlink:href="#icon-dropdown"></use></svg>
</div>
<ul class="enhance-SELECT"><li data-value="petrol" class="truncate" title="Essence">Essence</li>
<li data-value="diesel" class="truncate" title="Diesel">Diesel</li>
<li data-value="lpg" class="truncate" title="GPL">GPL</li>
<li data-value="electric" class="truncate" title="Electrique">Electrique</li></ul></div></div>

<div class="itinerary-options-costs">

<div class="itinerary-options itinerary-options-inline itinerary-options-SELECT itinerary-options-currency clearfx">
<div class="enhance-SELECT-container" data-view="shared/SELECT" data-SELECT_name="currency"><SELECT name="currency"><option value="EUR" >EUR</option>
<option value="CHF" >CHF</option>
<option value="CZK" >CZK</option>
<option value="DKK" >DKK</option>
<option value="GBP" >GBP</option>
<option value="HRK" >HRK</option>
<option value="HUF" >HUF</option>
<option value="NOK" >NOK</option>
<option value="PLN" >PLN</option>
<option value="SEK" >SEK</option>
<option value="UAH" >UAH</option>
<option value="USD" >USD</option></SELECT>
<div class="toggle-enhance-SELECT truncate" tabindex="-1">
<span class="SELECT-placeholder">EUR</span>
<svg class="icon icon-dropdown"><use xlink:href="#icon-dropdown"></use></svg>
</div>
<ul class="enhance-SELECT"><li data-value="EUR" class="truncate" title="EUR">EUR</li>
<li data-value="CHF" class="truncate" title="CHF">CHF</li>
<li data-value="CZK" class="truncate" title="CZK">CZK</li>
<li data-value="DKK" class="truncate" title="DKK">DKK</li>
<li data-value="GBP" class="truncate" title="GBP">GBP</li>
<li data-value="HRK" class="truncate" title="HRK">HRK</li>
<li data-value="HUF" class="truncate" title="HUF">HUF</li>
<li data-value="NOK" class="truncate" title="NOK">NOK</li>
<li data-value="PLN" class="truncate" title="PLN">PLN</li>
<li data-value="SEK" class="truncate" title="SEK">SEK</li>
<li data-value="UAH" class="truncate" title="UAH">UAH</li>
<li data-value="USD" class="truncate" title="USD">USD</li></ul></div>
</div>

<div class="itinerary-options itinerary-options-input itinerary-options-fuelCost clearfx">
<label for="fuelCost">Coût du carburant</label>
<input type="text" id="fuelCost" name="fuelCost" value="1.36" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
</div>
<div class="itinerary-options itinerary-options-input itinerary-options-allowance clearfx">
<label for="allowance">Indemnité kilométrique</label>
<input type="text" id="allowance" name="allowance" value="0" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
</div>

</div>

<h2 class="itinerary-options-title">Mes options de route</h2>

<div class="itinerary-options itinerary-options-SELECT itinerary-options-type clearfx">
<button type="button" class="open-tooltype"></button>
<div class="enhance-SELECT-container" data-view="shared/SELECT" data-label="itinerary_form_options_type_label" data-translation_prefix="itinerary_form_options_type_" data-SELECT_name="type" data-_block="        0
        1
        2
        3
        4
">  <label for="type">Itinéraire</label>
<SELECT name="type"><option value="0" >Conseillé Michelin</option>
<option value="1" >Le plus rapide (temps)</option>
<option value="2" >Le plus court (distance)</option>
<option value="3" >Découverte </option>
<option value="4" >Economique</option></SELECT>
<div class="toggle-enhance-SELECT truncate" tabindex="-1">
<span class="SELECT-placeholder">Conseillé Michelin</span>
<svg class="icon icon-dropdown"><use xlink:href="#icon-dropdown"></use></svg>
</div>
<ul class="enhance-SELECT"><li data-value="0" class="truncate" title="Conseillé Michelin">Conseillé Michelin</li>
<li data-value="1" class="truncate" title="Le plus rapide (temps)">Le plus rapide (temps)</li>
<li data-value="2" class="truncate" title="Le plus court (distance)">Le plus court (distance)</li>
<li data-value="3" class="truncate" title="Découverte ">Découverte </li>
<li data-value="4" class="truncate" title="Economique">Economique</li></ul></div></div>

<div class="itinerary-options itinerary-options-SELECT itinerary-options-distance clearfx">
<div class="enhance-SELECT-container" data-view="shared/SELECT" data-label="itinerary_form_options_distance_label" data-translation_prefix="itinerary_form_options_distance_" data-SELECT_name="distance" data-_block="        km
        mi
">  <label for="distance">Distance en</label>
<SELECT name="distance"><option value="km" >Kilomètres</option>
<option value="mi" >Miles</option></SELECT>
<div class="toggle-enhance-SELECT truncate" tabindex="-1">
<span class="SELECT-placeholder">Kilomètres</span>
<svg class="icon icon-dropdown"><use xlink:href="#icon-dropdown"></use></svg>
</div>
<ul class="enhance-SELECT"><li data-value="km" class="truncate" title="Kilomètres">Kilomètres</li>
<li data-value="mi" class="truncate" title="Miles">Miles</li></ul></div></div>

<div class="itinerary-options itinerary-options-boolean itinerary-options-highway clearfx">
<label for="highway" class="enhance-checkbox">
<input type="checkbox" id="highway" name="highway" value=""  />
<span class="checkbox"></span>
<span>Eviter les autoroutes / voies rapides</span>
</label>
</div>
<div class="itinerary-options itinerary-options-boolean itinerary-options-toll clearfx">
<label for="toll" class="enhance-checkbox">
<input type="checkbox" id="toll" name="toll" value=""  />
<span class="checkbox"></span>
<span>Eviter les péages</span>
</label>
</div>
<div class="itinerary-options itinerary-options-boolean itinerary-options-vignette clearfx">
<label for="vignette" class="enhance-checkbox">
<input type="checkbox" id="vignette" name="vignette" value=""  />
<span class="checkbox"></span>
<span>Eviter les vignettes (Suisse,...)</span>
</label>
</div>
<div class="itinerary-options itinerary-options-boolean itinerary-options-orc clearfx">
<label for="orc" class="enhance-checkbox">
<input type="checkbox" id="orc" name="orc" value=""  />
<span class="checkbox"></span>
<span>Eviter les liaisons maritimes</span>
</label>
</div>
<div class="itinerary-options itinerary-options-boolean itinerary-options-crossing clearfx">
<label for="crossing" class="enhance-checkbox">
<input type="checkbox" id="crossing" name="crossing" value="" checked />
<span class="checkbox"></span>
<span>Autoriser la sortie du pays</span>
</label>
</div>
<div class="itinerary-options itinerary-options-boolean itinerary-options-caravan clearfx">
<label for="caravan" class="enhance-checkbox">
<input type="checkbox" id="caravan" name="caravan" value=""  />
<span class="checkbox"></span>
<span>Voiture avec caravane</span>
</label>
</div>

<div class="itinerary-options-submit">
<button type="submit">Rechercher</button>
</div>
</div>

</form>

<button type="button" class="show-search-form">Modifier l&#x27;itinéraire</button>
</div>
<div id="advertising_300" class="ads" data-label="PUBLICITÉ"></div>
<div id="advertising_300x105" class="ads"></div>
<div class="fixedsticky">
<div data-view="itinerary/index/push_hotel">	<div class="push-hotel push-hotel-iti">
<p class="push-title">
