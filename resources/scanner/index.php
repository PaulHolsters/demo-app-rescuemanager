<style>
    #preview {
        width: 100px;
        height: 100px;
        background-color: #601241;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 0.6rem auto;
        border-radius: 32px;
    }
    .scanner{
        width: 100%;
        height: fit-content;
        background-color: #601241;
        padding: 1rem 0;
    }
    .scanner > span{
        display: block;
        text-align: center;
        color: yellow;
        position: absolute;
        width: 100%;
        z-index: 5;
        font-size: 1.4rem;
        margin-top: 1rem;
    }
</style>
<div class="scanner">
    <span>Scanner laden...</span>
    <video id="preview" autoplay></video>
</div>

