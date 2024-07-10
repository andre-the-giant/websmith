
</main>
<footer>
        <div class="mission">
            <div class="content">
                <div>
                    <h2><?php 
                        if($company["logo"] && !empty($company["logo"])){
                            echo '<div class="logo"><a href="/" class="logo-link"><img src="'.$company["logo"].'" alt="'.$company["name"].'"></a></div>';
                        }
        ?>      </h2>
                    <p>
                        <?=$company["description"]?>
                    </p>
                </div>
                <div>
                    <img src="/img/barbequepro_logo.png" alt="barbeque pro inc." class="logo-round">
                    <ul class="social-icons">
                        <?= generateSocialMediaLinks("facebook","instagram","youtube")?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="address-block">
            <div class="content">
                <div class="phone-email"><?=$company['telephone']?> &nbsp;&nbsp;&nbsp;<?=$company['email']?></div>
                <div class="location">
                    <h3><?=$company['name']?><</h3>
                    <div class="address">
                        <?= $company["address_street1"]?>
                        <?= $company["address_city"]?>
                        <?= $company["address_province"]?>
                        <?= $company["address_postalcode"]?>
                        <?= $company["address_country"]?>
                    </div>
                </div>
            </div>
        </div>
</footer>
<div aria-hidden="true">
    <?php
    echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/curve-in-top.svg");
    echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/curve-in-bottom.svg");
    echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/curve-out-top.svg");
    echo file_get_contents($_SERVER['DOCUMENT_ROOT']."/svg/curve-out-bottom.svg");
    ?>
</div>
<nav class="mobile-nav">
    <a href="/">
        <img src="/svg/booking.svg" alt="Booking">
    </a>
    <a href="tel:<?=$company["telephone_short"]?>">
        <img src="/svg/call.svg" alt="Call us">
    </a>
    <a href="mailto:<?=$company["email"] ?>">
        <img src="/svg/email.svg" alt="Email us">
    </a>
</nav>
<!-- Scripts -->
<script src="/js/main.js"></script>
</body>
</html>