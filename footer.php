<style>
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: grey;
        text-align: center;
        display: flex; /* Verwenden Sie Flexbox für das Layout */
        justify-content: center; /* Horizontal zentrieren */
        align-items: center; /* Vertikal zentrieren */
        max-height: 100%; /* Maximalhöhe des Footers auf 100% des Viewports setzen */
    }

    .footer-content {
        padding: 20px;
        display: flex; /* Verwenden Sie Flexbox für das Layout */
        align-items: center; /* Vertikal zentrieren */
    }

    .footer img {
        max-width: 80px; /* Reduzieren Sie die Breite des Bildes */
        height: auto;
        margin-right: 10px; /* Fügen Sie einen Abstand zwischen dem Logo und dem Text hinzu */
    }

    .footer-content h6, .footer-content p {
        font-size: 12px; /* Reduzieren Sie die Schriftgröße für h6 und p */
        margin: 0; /* Entfernen Sie den Standardabstand */
    }
    .footer a {
    color: #e60000;
    }
    .footer a:hover{
        color:darkred;
    }
</style>

<div class="footer">
    <div class="footer-content">
        <img src="bfw.png" alt="BFW Logo">
        <div>
            <h6>BFW Nürnberg</h6>
            <p>Schleswiger Str. 101<br>
            90427 Nürnberg<br>
            Telefon: 0911 938-6<br>
            Fax: 0911 938-7305<br>
            <a href="https://www.bfw-nuernberg.de/index.html" target="_blank">www.bfw-nuernberg.de</a></p>
        </div>
    </div>
</div>
