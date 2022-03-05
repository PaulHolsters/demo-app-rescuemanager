<?php
include('resources/scanner/index.php');
?>

<!--     ***********************       INVENTARIS     ***********************       -->

<div id="inventory-wrapper">
    <a id="goToTop" onclick="goToTop()">Overzicht inventaris</a>
    <hr>
    <p class="message-info">Start de inventaris door een artikel te scannen...</p>
    <p class="message-success">Inventaris ok!</p>
    <p class="message-success">Artikel ok!</p>
    <p class="message-failure">Artikel nok!</p>
    <hr>
    <label><b>Gescand artikel:</b></label>
    <label id="scannedArticle"></label>
    <hr>
    <label id="articleNumber"><b>Artikelnummer:</b> <span></span></label>
    <label id="articleNumber"><b>Keuringstermijn:</b> <input type="number" required min="0" step="1" oninput="inventaris.onChangeElement('inspection_period')"> weken</label>
    <label id="articleDefect"><b>Defect:</b>
        <textarea rows="4" oninput="inventaris.onChangeElement('defect')"></textarea>
    </label>
    <label id="articleLocation"><b>Locatie:</b>
        <select>
            <option selected>   Wagen</option>
            <option>            Magazijn</option>
        </select>
    </label>
    <input id="articleResetBtn" type="button" value="Terugzetten" onclick="inventaris.resetForm()">
    <input id="articleSaveBtn" type="button" value="Bewaren" onclick="inventaris.saveArticle()">
    <hr>
    <label>Overzicht inventaris</label>
    <hr>
    <ul>
        <li>

        </li>
    </ul>
    <a id="goToBottom" onclick="goToBottom()">Verder scannen</a>
</div>

<style>
    #goToTop,#goToBottom{
        width: 94%;
        margin-left: auto;
        margin-right: auto;
        padding: 6px;
        font-size: 1.2rem;
        display: block;
        margin-top:8px;
        text-align: center;
    }

    .message-info {
        color:royalblue;
        text-align: center;
        font-size: 1.1rem;
    }

    .message-success {
        color: #497309;
        text-align: center;
        font-size: 1.1rem;
    }

    .message-failure {
        color: red;
        text-align: center;
        font-size: 1.1rem;
    }
</style>
<script>
    const inventaris =  {

        init: function () {
            document.getElementById('stopInventoryBtn').style.display = 'none';
        },
        processArticle: function (event) {

        },
        startInventory: function () {
            document.getElementById('stopInventoryBtn').style.display = 'block';
            document.getElementById('startInventoryBtn').style.display = 'none';
        },
        stopInventory: function () {
            document.getElementById('stopInventoryBtn').style.display = 'none';
            document.getElementById('startInventoryBtn').style.display = 'block';
        },
        onChangeElement: function(element){

        }
    }
</script>


