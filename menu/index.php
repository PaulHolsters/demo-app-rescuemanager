<script>
    let scanner;
    let player;
    let scannerReady = false;
    let teardownDone = false;
    let forbidden = false;
    let previousResult = '';
    let compContainer;
    let setUp;
    let tearDown;

    window.addEventListener('load',initialize);

    function initialize(){
        compContainer = document.querySelector('body > div:nth-of-type(2)');
    }

    function setScannerReady(event) {
        scannerReady = true;
        player = event.detail[0];
        scanner = event.detail[1];
        const elements = document.querySelectorAll('body > div:first-of-type button:not([class="active"])');
        for (let i = 0; i < elements.length; i++) {
            elements[i].removeAttribute('disabled');
            elements[i].setAttribute('class',elements[i].getAttribute('class').replace('disabled','inactive'));
        }
        document.querySelector('.scanner > span').remove();
    }

    function setTeardownDone() {
        teardownDone = true;
    }

    function removeActiveComponent() {
        while (compContainer.hasChildNodes()) {
            compContainer.removeChild(compContainer.childNodes[0]);
        }
    }

    function addComponent(componentName) {
        compContainer.setAttribute('class', componentName);
        const template = document.getElementById(componentName);
        const clone = template.content.cloneNode(true);
        compContainer.appendChild(clone);
    }

    function updateMenu(setToActive) {
        if (!forbidden) {
            const element = document.querySelector('body > div:first-of-type > button[class="active"]');
            if(element.innerHTML.toLowerCase() !== setToActive){
                element.setAttribute('class',element.getAttribute('class').replace('active','inactive'));
            }
            const elements = document.querySelectorAll('body > div:first-of-type > button[class="inactive"]');
            for (let i = 0; i < elements.length; i++) {
                if(elements[i].innerHTML.toLowerCase() === setToActive){
                    elements[i].setAttribute('class',elements[i].getAttribute('class').replace('inactive','active'));
                }
            }
            if (setToActive === 'materiaalbeheer' &&
                compContainer.getAttribute('class') !== 'materiaalbeheer') {
                previousResult = '';
                removeActiveComponent();
                addComponent(setToActive);
                const event = new CustomEvent('player-ready', {detail: setToActive});
                document.getElementById('preview').addEventListener('player-ready', setUpScanner, false);
                document.getElementById('preview').dispatchEvent(event);
                materiaalbeheer.init();
            } else if (setToActive === 'materiaalbeheer' &&
                compContainer.getAttribute('class') === 'materiaalbeheer') {
            } else if (setToActive !== 'materiaalbeheer' &&
                compContainer.getAttribute('class') !== 'materiaalbeheer') {
                removeActiveComponent();
                addComponent(setToActive);
            } else if (setToActive !== 'materiaalbeheer' &&
                compContainer.getAttribute('class') === 'materiaalbeheer') {
                while (!scannerReady) {
                }
                const event = new CustomEvent('exit-scanner', {detail: [player, scanner]});
                document.getElementById('preview').addEventListener('exit-scanner', teardownScanner, false);
                document.getElementById('preview').dispatchEvent(event);
                while (!teardownDone) {
                }
                removeActiveComponent();
                addComponent(setToActive);
                teardownDone = false;
                scannerReady = false;
            }
        }
    }

    function setUpScanner(event) {
        forbidden = true;
        const elements = document.querySelectorAll('body > div:first-of-type button:not([class="active"])');
        for (let i = 0; i < elements.length; i++) {
            elements[i].setAttribute('disabled', 'true');
            elements[i].setAttribute('class',elements[i].getAttribute('class').replace('inactive','disabled'));
        }
        const player = document.querySelector('#preview');
        navigator.mediaDevices.getUserMedia({video: {facingMode: {exact: "environment"}}}).then(
            function (stream) {
                player.srcObject = stream;
                const qrScanner = new QrScanner(player,
                    result => {
                        if(result !== previousResult){
                            previousResult = result;
                            const scanEvent = new CustomEvent('scanner-result', {bubbles: true, detail: result});
                            switch (event.detail){
                                case 'materiaalbeheer':
                                    document.getElementById('preview').addEventListener('scanner-result', materiaalbeheer.getAndOutputArticle, false);
                                    break;
                                case 'inventaris':
                                    document.getElementById('preview').addEventListener('scanner-result', inventaris.processArticle, false);
                                    break;
                                case 'duikoefening':
                                    break;
                            }
                            document.getElementById('preview').dispatchEvent(scanEvent);
                        }
                    }, QrScanner._onDecodeError, 400);
                qrScanner.start();
                const scanReadyEvent = new CustomEvent('scanner-ready', {bubbles: true, detail: [player, qrScanner]});
                document.getElementById('preview').addEventListener('scanner-ready', setScannerReady, false);
                document.getElementById('preview').dispatchEvent(scanReadyEvent);
                forbidden = false;
            }
        ).catch(err => {

        });
    }

    function teardownScanner() {
        scanner.stop();
        if (player.srcObject) {
            player.srcObject.getVideoTracks().forEach(track => {
                track.stop();
            });
        }
        const event = new Event('teardown-done');
        document.getElementById('preview').addEventListener('teardown-done', setTeardownDone, false);
        document.getElementById('preview').dispatchEvent(event);
    }



</script>
<style>
    body > div:first-of-type {
        width: 100%;
    }

    body > div:first-of-type > button[class="inactive"] {

        background-color: #fa8509;
        color: whitesmoke;

        padding: 12px 10px;
        display: block;
        width: 100%;
    }

    body > div:first-of-type > button[class="active"] {
        background-color: #601241;
        color: whitesmoke;

        padding: 12px 10px;
        display: block;
        width: 100%;
    }

    body > div:first-of-type > button[class="disabled"] {
        background-color: #abaaaa;
        color: whitesmoke;

        padding: 12px 10px;
        display: block;
        width: 100%;
    }

    body > div:first-of-type > button:hover {
        cursor: pointer;
    }
</style>
<div>
    <button onclick="updateMenu('home');" class="active">Home</button>
    <button onclick="updateMenu('materiaalbeheer');" class="inactive">Materiaalbeheer</button>
    <button onclick="updateMenu('inventaris');" class="inactive">Inventaris</button>
    <button onclick="updateMenu('duikoefening');" class="inactive">Duikoefening</button>
</div>

