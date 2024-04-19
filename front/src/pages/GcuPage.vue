<template>
  <div>
    <h2 class="page-title"> Conditions générales d'utilisation </h2>
    <Breadcrumb />

    <section>
      <p>Les présentes conditions générales d'utilisation régissent l'utilisation du site Internet {{ FRONT_URL }}. En
        accédant à ce site, vous acceptez sans réserve les présentes conditions.</p>
    </section>
    
    <section>
      <h3 class="section-title">Utilisation du site</h3>
      <p>Le site {{ FRONT_URL }} est accessible gratuit
        ement à tout utilisateur disposant d'un accès à internet. L'utilisateur s'engage à ne pas perturber le
        fonctionnement du site ni à porter atteinte à son intégrité.</p>
    </section>
    <section>
      <h3 class="section-title">Contenu du site</h3>
      <p>Le contenu du site, y compris les textes, images, vidéos, et autres éléments, est protégé par le droit
        d'auteur. Toute reproduction ou utilisation sans autorisation est strictement interdite.</p>
    </section>

    <section>
      <h3 class="section-title">Collecte de données personnelles</h3>
      <p>En naviguant sur le site, vous acceptez l'utilisation de cookies conformément à notre politique de
        confidentialité. Les données collectées sont utilisées à des fins d'amélioration de l'expérience utilisateur et
        de personnalisation du contenu.</p>
    </section>

    <section>
      <h3 class="section-title">Liens hypertextes</h3>
      <p>Le site peut contenir des liens hypertextes vers d'autres sites internet. Ces liens sont fournis à titre
        informatif et {{ COMPANY_NAME }} n'assume aucune responsabilité quant au contenu de ces sites.</p>
    </section>

    <section>
      <h3 class="section-title">Limitation de responsabilité</h3>
      <p>{{ COMPANY_NAME }} s'efforce de fournir un contenu de qualité sur son site, mais ne peut garantir l'exactitude
        et l'exhaustivité des informations. En aucun cas, {{ COMPANY_NAME }} ne pourra être tenu pour responsable des
        dommages directs ou indirects résultant de l'utilisation du site.</p>
    </section>

    <section>
      <h3 class="section-title">Modifications des conditions d'utilisation</h3>
      <p>Les présentes conditions d'utilisation peuvent être modifiées à tout moment par {{ COMPANY_NAME }}. Les
        utilisateurs sont invités à consulter régulièrement cette page pour prendre connaissance des éventuelles
        modifications.</p>
    </section>

    <section>
      <h3 class="section-title">Droit applicable</h3>
      <p>Les présentes conditions d'utilisation sont régies par le droit français. En cas de litige, les tribunaux
        français seront seuls compétents.</p>
    </section>

  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
</script>

<style scoped></style>
