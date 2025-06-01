<link rel="stylesheet"
      type="text/css"
      media="print"
      onload="this.media='all'"
      href="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.css"
/>
<script async src="https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.1/cookieconsent.min.js"></script>
<script>
    window.addEventListener('load', function () {
        window.cookieconsent.initialise({
            revokeBtn: "<div class='cc-revoke'></div>",
            type: "opt-in",
            theme: "classic",
            palette: {
                popup: {
                    background: "#1D1D1D",
                    text: "#fff"
                },
                button: {
                    background: "#fff",
                    text: "#28f"
                }
            },
            content: {
                message: "Utilizamos COOKIES e afins de acordo com nossa Política de Privacidade, ao continuar navegando você concorda com estas condições.",
                link: "SAIBA MAIS",
                allow: "ACEITAR",
                deny: " ",
                href: "https://docs.google.com/document/d/e/2PACX-1vRXIhJHkt7X6de3pQDes5pMmamMacA2lRdgtelWBQIMi8gtQhRH4lxhy3gsA_2b3NJJp794EnMDhLh_/pub"
            },
            onInitialise: function (status) {
                // if (status === cookieconsent.status.allow) {
                // }
            },
            onStatusChange: function (status) {
                // if (this.hasConsented())
            }
        })
    });
</script>
