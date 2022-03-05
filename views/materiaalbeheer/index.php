<?php
include('resources/scanner/index.php');
?>
<form id="saveArticle">
    <label id="articleName"><b>Artikel:</b>
        <span></span>
    </label>
    <label id="articleStatus"><b>Status:</b>
        <span></span>
    </label>
    <label id="articleDefect"><b>Defect:</b>
        <textarea rows="4" oninput="materiaalbeheer.onChangeElement('defect')"></textarea>
    </label>
    <label id="articleCheckout">
        <input type="radio" name="repairStatus" oninput="materiaalbeheer.onChangeElement('checkout')">Check-out
    </label>
    <label id="articleCheckin">
        <input type="radio" name="repairStatus" oninput="materiaalbeheer.onChangeElement('checkin')">Check-in
    </label>
    <input id="articleResetBtn" type="button" value="Terugzetten" onclick="materiaalbeheer.resetForm()">
    <input id="articleSaveBtn" type="button" value="Bewaren" onclick="materiaalbeheer.saveArticle()">
</form>
<p class="message-info">Scan een artikel om het vervolgens te kunnen bewerken...</p>
<p class="message-success">Artikel bewaard!</p>
<style>
    #saveArticle{
        background-color: #cdbdbd;
        padding-bottom: 2px;
    }

    #saveArticle > label {
        display: block;
        width: 94%;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1rem;
        text-align: left;
    }

    #articleDefect > textarea{
        display: block;
        width: 98%;
        margin-left: auto;
        margin-right: auto;
        margin-top:2px;
        margin-bottom: 2px;
    }

    #articleCheckout, #articleCheckin{
        margin-top:2px;
        margin-bottom: 2px;
    }

    #articleDefect.disabled, #articleCheckout.disabled, #articleCheckin.disabled{
        color: #837575;
    }

    input[type="button"]{
        width: 94%;
        margin-left: auto;
        margin-right: auto;
        padding: 6px;
        font-size: 1.2rem;
        display: block;
        margin-top:8px;
    }

    #articleResetBtn{
        background-color: cadetblue;
        color: white;
    }

    #articleSaveBtn{
        background-color: coral;
        color: white;
    }

    #articleResetBtn.disabled{
        background-color: #657172;
        color: #b7a5a5;
    }

    #articleSaveBtn.disabled{
        background-color: #644e47;
        color: #999494;
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
</style>
<script>
    const materiaalbeheer =  {
            articles: [],
            articleName: null,
            articleStatus: null,
            articleDefect: null,
            articleCheckout: null,
            articleResetBtn: null,
            articleSaveBtn: null,
            loadedArticle: null,
            messaging: null,
            init: function () {
                this.articles = [
                    {id: 'art1', name: 'duikbril', status: 'ok', defect: ''},
                    {id: 'art2', name: 'duikbril', status: 'ok', defect: ''},
                    {id: 'art3', name: 'snorkel', status: 'te herstellen', defect: 'is ook al ni goe meer'},
                    {id: 'art4', name: 'zwemvlies', status: 'te herstellen', defect: 'ziet er niet goed uit'},
                    {
                        id: 'art5',
                        name: 'bandjes',
                        status: 'naar leverancier',
                        defect: 'voor pampus ligt hij de fooraap'
                    },
                    {id: 'art6', name: 'schietlood', status: 'ok', defect: ''},
                    {id: 'art7', name: 'nanometer', status: 'naar leverancier', defect: 'pampus'},
                    {id: 'art8', name: 'duikfles 5L', status: 'ok', defect: ''}
                ];
                this.articleName = materiaalbeheer.getForm('name');
                this.articleStatus = materiaalbeheer.getForm('status');
                this.articleDefect = materiaalbeheer.getForm('defect');
                this.articleCheckout = materiaalbeheer.getForm('checkout');
                this.articleResetBtn = materiaalbeheer.getForm('reset-btn');
                this.articleSaveBtn = materiaalbeheer.getForm('save-btn');
                this.loadedArticle = {};

                document.querySelector('#saveArticle').style.display = 'none';
                document.querySelector('.message-info').style.display = 'block';
                document.querySelector('.message-success').style.display = 'none';
            },
            getForm: function (element) {
                switch (element) {
                    case 'name':
                        return document.querySelector('#articleName > span').innerHTML;
                    case 'status':
                        return document.querySelector('#articleStatus > span').innerHTML;
                    case 'defect':
                        return document.querySelector('#articleDefect > textarea').value;
                    case 'checkout':
                        return {
                            checked: document.querySelector('#articleCheckout > input').hasAttribute('checked'),
                            disabled: document.querySelector('#articleCheckout > input').hasAttribute('disabled')
                        };
                    case 'reset-btn':
                        return document.querySelector('#articleResetBtn').hasAttribute('disabled');
                    case 'save-btn':
                        return document.querySelector('#articleSaveBtn').hasAttribute('disabled');
                }
            },
            updateForm: function (element, newValue, disable) {
                switch (element) {
                    case 'name':
                        document.querySelector('#articleName > span').innerHTML = newValue;
                        this.articleName = materiaalbeheer.getForm(element);
                        break;
                    case 'status':
                        document.querySelector('#articleStatus > span').innerHTML = newValue;
                        this.articleStatus = materiaalbeheer.getForm(element);
                        break;
                    case 'defect':
                        if (newValue !== null) {
                            document.querySelector('#articleDefect > textarea').value = newValue.trim();
                        }
                        document.querySelector('#articleDefect > textarea').disabled = !!disable;
                        if(disable && !document.querySelector('#articleDefect').classList.contains('disabled')){
                            document.querySelector('#articleDefect').classList.add('disabled')
                        } else if(!disable && document.querySelector('#articleDefect').classList.contains('disabled')){
                            document.querySelector('#articleDefect').classList.remove('disabled')
                        }
                        this.articleDefect = materiaalbeheer.getForm(element);
                        break;
                    case 'checkout':
                        document.querySelector('#articleCheckout > input').checked = !!newValue;
                        document.querySelector('#articleCheckout > input').disabled = !!disable;
                        if(disable && !document.querySelector('#articleCheckout').classList.contains('disabled')){
                            document.querySelector('#articleCheckout').classList.add('disabled')
                        } else if(!disable && document.querySelector('#articleCheckout').classList.contains('disabled')){
                            document.querySelector('#articleCheckout').classList.remove('disabled')
                        }
                        this.articleCheckout = materiaalbeheer.getForm(element);
                        break;
                    case 'checkin':
                        document.querySelector('#articleCheckin > input').checked = !!newValue;
                        document.querySelector('#articleCheckin > input').disabled = !!disable;
                        if(disable && !document.querySelector('#articleCheckin').classList.contains('disabled')){
                            document.querySelector('#articleCheckin').classList.add('disabled')
                        } else if(!disable && document.querySelector('#articleCheckin').classList.contains('disabled')){
                            document.querySelector('#articleCheckin').classList.remove('disabled')
                        }
                        break;
                    case 'reset-btn':
                        document.querySelector('#articleResetBtn').disabled = !!newValue;
                        if(newValue && !document.querySelector('#articleResetBtn').classList.contains('disabled')){
                            document.querySelector('#articleResetBtn').classList.add('disabled')
                        } else if(!newValue && document.querySelector('#articleResetBtn').classList.contains('disabled')){
                            document.querySelector('#articleResetBtn').classList.remove('disabled')
                        }
                        this.articleResetBtn = materiaalbeheer.getForm(element);
                        break;
                    case 'save-btn':
                        document.querySelector('#articleSaveBtn').disabled = !!newValue;
                        if(newValue && !document.querySelector('#articleSaveBtn').classList.contains('disabled')){
                            document.querySelector('#articleSaveBtn').classList.add('disabled')
                        } else if(!newValue && document.querySelector('#articleSaveBtn').classList.contains('disabled')){
                            document.querySelector('#articleSaveBtn').classList.remove('disabled')
                        }
                        this.articleSaveBtn = materiaalbeheer.getForm(element);
                        break;
                }
            },
            updateButtons: function() {
                if (!(this.loadedArticle.status === this.articleStatus && this.loadedArticle.defect === this.articleDefect)) {
                    materiaalbeheer.updateForm('reset-btn', false);
                    this.articleResetBtn = materiaalbeheer.getForm('reset-btn');
                    materiaalbeheer.updateForm('save-btn', false);
                    this.articleSaveBtn = materiaalbeheer.getForm('save-btn');
                } else {
                    materiaalbeheer.updateForm('reset-btn', true);
                    this.articleResetBtn = materiaalbeheer.getForm('reset-btn');
                    materiaalbeheer.updateForm('save-btn', true);
                    this.articleSaveBtn = materiaalbeheer.getForm('save-btn');
                }
            },
            onChangeElement: function (element) {
                switch (element) {
                    case 'defect':
                        this.articleDefect = materiaalbeheer.getForm(element);
                        switch (this.articleStatus) {
                            case 'ok':
                                if (this.articleDefect.length > 0) {
                                    materiaalbeheer.updateForm('status', 'te herstellen');
                                    materiaalbeheer.updateForm('checkout', false);
                                    // nothing to update for checkin
                                }
                                break;
                            case 'te herstellen':
                                if (this.articleDefect.length === 0) {
                                    materiaalbeheer.updateForm('status', 'ok')
                                    materiaalbeheer.updateForm('checkout', false, true);
                                    materiaalbeheer.updateForm('checkin', false, true);
                                }
                                break;
                        }
                        break;
                    case 'checkout':
                        this.articleCheckout = materiaalbeheer.getForm(element);
                        materiaalbeheer.updateForm('checkin', false);
                        materiaalbeheer.updateForm('defect', null, true);
                        materiaalbeheer.updateForm('status', 'naar leverancier');
                        break;
                    case 'checkin':
                        materiaalbeheer.updateForm('status', 'ok');
                        materiaalbeheer.updateForm('defect', '');
                        materiaalbeheer.updateForm('checkout', false, true);
                        materiaalbeheer.updateForm('checkin', false, true);
                        break;
                }
                materiaalbeheer.updateButtons();
            },
            getAndOutputArticle: function (event) {
/*                window.alert(this) // this is the videoElement*/
/*                window.alert(this.messaging); // undefined!!!*/
/*                window.alert(materiaalbeheer.messaging) // works*/
                if (materiaalbeheer.messaging) {
                    clearTimeout(materiaalbeheer.messaging);
                }
                if (document.querySelector('#saveArticle').style.display === 'none') {
                    document.querySelector('#saveArticle').style.display = 'block';
                    document.querySelector('.message-info').style.display = 'none';
                    document.querySelector('.message-success').style.display = 'none';
                }
                materiaalbeheer.loadedArticle = {
                    ...materiaalbeheer.articles.find(article => {
                        return (article.id === event.detail);
                    })
                };
                materiaalbeheer.resetForm();
            },
            resetForm: function() {
                this.updateForm('name', this.loadedArticle.name);
                this.updateForm('status', this.loadedArticle.status);
                this.updateForm('defect', this.loadedArticle.defect);
                switch (this.articleStatus) {
                    case 'ok':
                        this.updateForm('checkout', false, true);
                        this.updateForm('checkin', false, true);
                        break;
                    case 'te herstellen':
                        this.updateForm('checkout', false);
                        this.updateForm('checkin', false, true);
                        break;
                    case 'naar leverancier':
                        this.updateForm('checkout', true);
                        this.updateForm('checkin', false);
                        break;
                }
                this.updateButtons();
            },
            saveArticle: function () {
                const updatedArticle = {
                    id: this.loadedArticle.id,
                    name: this.loadedArticle.name,
                    status: this.articleStatus,
                    defect: this.articleDefect
                };
                const index = this.articles.findIndex(el => el.id === materiaalbeheer.loadedArticle.id);
                this.articles.splice(index, 1, updatedArticle);
                document.querySelector('#saveArticle').style.display = 'none';
                document.querySelector('.message-success').style.display = 'block';
                document.querySelector('.message-info').style.display = 'none';
                this.messaging = setTimeout(() => {
                    document.querySelector('.message-success').style.display = 'none';
                    document.querySelector('.message-info').style.display = 'block';
                    materiaalbeheer.messaging = null;
                }, 3000);
            }
    }

</script>


