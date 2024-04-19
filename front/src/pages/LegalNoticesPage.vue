<template>
  <div>
    <h2 class="page-title">Mentions légales</h2>
    <Breadcrumb />

    <section>
      <h3 class="section-title">Éditeur du site</h3>
      <p>Vous êtes sur le site Internet : <a :href="FRONT_URL" class="link">{{ FRONT_URL }}</a></p>
      <p>Le site « {{ FRONT_URL }} » ainsi que tous ses composants sont la propriété de {{ COMPANY_NAME }}.</p>
      <br>
      <p>{{ COMPANY_NAME }}</p>
      <p>Adresse : Lorem ipsum dolor sit amet</p>
      <p>Téléphone : <a class="link" href="tel:+33000000000">00 00 00 00 00</a></p>
      <p>E-mail : <a class="link" href="mailto:contact@new-vet.com">contact@new-vet.com</a></p>
    </section>

    <section>
      <h3 class="section-title">Responsabilités</h3>
      <p>{{ COMPANY_NAME }} s'efforce de fournir des informations exactes et à jour sur son site, mais ne peut
        garantir
        l'exactitude et l'exhaustivité des informations fournies.</p>
      <p>En cas d'erreur ou d'omission, veuillez nous contacter pour rectification.</p>
      <p>Le contenu du site respecte les lois en vigueur et notamment :</p>
      <p>La loi sur la liberté de la presse de sorte qu'aucun écrit, image ou son à caractère diffamatoire, raciste ou
        révisionniste ne sera mis en ligne ;</p>
      <p>Conformément à l'article 227-24 du Code pénal relatif à la protection des mineurs, aucun message à caractère
        violent, pornographique ou portant gravement atteinte à la dignité humaine susceptible d'être vu ou perçu par un
        mineur ne sera mis en ligne ;</p>
      <p>Conformément à la loi LCEN du 22 juin 2004, un droit de réponse est ouvert à toute personne nommée ou désignée
        sur
        le site. La demande doit être faite à {{ COMPANY_NAME }} au plus tard dans les trois mois de la mise à
        mise en ligne du contenu.</p>
    </section>

    <section>
      <h3 class="section-title">Collecte de données personnelles</h3>
      <p>Le site de {{ COMPANY_NAME }} collecte des données personnelles à des fins d'amélioration de l'expérience
        utilisateur et de personnalisation du contenu. En naviguant sur ce site, vous acceptez l'utilisation de cookies
        conformément à nos <a class="link" to="/conditions-generales-d-utilisation">conditions générales d'utilisation</a>
      </p>
    </section>

    <section>
      <h3 class="section-title">Loi informatique, fichiers et libertés et protection des données personnelles</h3>
      <p>Les utilisateurs du site sont tenus de respecter les dispositions de la loi informatique, fichiers et libertés,
        dont
        la violation est passible de sanctions pénales. Ils doivent notamment s'abstenir, s'agissant des informations
        nominatives auxquelles ils accèdent, de toute collecte, de toute utilisation détournée et, d'une manière générale,
        de tout acte susceptible de porter atteinte à la vie privée ou à la réputation des personnes.</p>

      <p>{{ COMPANY_NAME }} ne pourra être tenue pour responsable de tout dommage direct et/ou indirect résultant de
        l'utilisation faite par l'utilisateur du site et/ou de toute information qu'il contient.</p>

      <p>Le site mon-nouveau-site.com peut renvoyer l'utilisateur à d'autres sites internet par le biais de liens
        hypertexte. {{ COMPANY_NAME }} ne saurait être responsable du contenu de ces sites, lesquels relèvent de
        l'entière
        responsabilité de leurs titulaires.</p>

      <p>Certains dangers sont inhérents à l'utilisation d'internet et l'utilisateur est mis en garde quant à la
        nécessité de prendre en compte les risques potentiels (toute infection par virus d'ordinateur, tout bug, tout
        ralentissement, etc…) avant de procéder à la consultation du site mon-nouveau-site.com.</p>
    </section>

    <section>
      <h3 class="section-title">Propriété intellectuelle et droit d'auteur</h3>
      <p>Le contenu de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété
        intellectuelle.</p>

      <p>{{ COMPANY_NAME }} conserve tous les droits patrimoniaux et moraux liés aux documents de ce site, sous
        réserve
        des droits dont bénéficient les auteurs d'œuvres publiées sur ce site. Ainsi, tous les droits de reproduction, sur
        supports électroniques ou papier, sont-ils réservés, y compris pour les documents téléchargeables et les
        représentations iconographiques et/ou photographiques.</p>
    </section>

    <section>
      <p>Date de dernière mise à jour : 04/19/2024</p>
    </section>

  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { FRONT_URL, COMPANY_NAME } from '@/config';

</script>

<style scoped></style>
