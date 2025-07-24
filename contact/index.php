<?php
    require_once dirname(__DIR__) . '/inc/init.php';

    require_once dirname(__DIR__) . '/inc/header.php';
?>
<div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2624.0840589006702!2d2.3473487153533092!3d48.875674079289205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66e14ce200109%3A0x64ba747f53868d45!2s50%20Rue%20de%20Paradis%2C%2075010%20Paris!5e0!3m2!1sfr!2sfr!4v1621441007435!5m2!1sfr!2sfr" height="550" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>
<div class="contact">
    <h4>Contater le service client</h4>
    <form action="" method="post">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom et prénom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Andi Loa">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Andi@mail.com">
        </div>
        <div class="mb-3">
            <label for="sujet" class="form-label">Sujet</label>
            <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet">
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" placeholder="Votre message"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Nous contacter</button>
    </form>
    <p>Vous pouvez nous joindre directement par téléphone au +33 75 65 25 45</p>
</div>

<?php
    require_once dirname(__DIR__) . '/inc/footer.php';