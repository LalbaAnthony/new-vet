<template>
  <div>
    <h2 class="page-title"> Conditions générales de vente </h2>
    <Breadcrumb />
    
    <section>
      <p>Les présentes conditions générales de vente régissent les relations contractuelles entre {{ COMPANY_NAME }} et
        ses clients dans le cadre de la vente des produits proposés sur le site Internet {{ FRONT_URL }}.</p>
    </section>

    <section>
      <h3 class="section-title">Objet</h3>
      <p>Les présentes conditions ont pour objet de définir les modalités de vente entre {{ COMPANY_NAME }} et le client,
        de la commande à la livraison, en passant par le paiement et l'utilisation des services.</p>
    </section>

    <section>
      <h3 class="section-title">Commandes</h3>
      <p>Le client peut passer commande sur le site Internet {{ FRONT_URL }}. Toute commande implique l'acceptation pleine
        et entière des présentes conditions générales de vente.</p>
    </section>

    <section>
      <h3 class="section-title">Prix</h3>
      <p>Les prix des produits sont indiqués en euros toutes taxes comprises (TTC). {{ COMPANY_NAME }} se réserve le droit
        de modifier ses prix à tout moment mais s'engage à appliquer les tarifs en vigueur indiqués au moment de la
        commande.</p>
    </section>

    <section>
      <h3 class="section-title">Paiement</h3>
      <p>Le paiement s'effectue en ligne par carte bancaire. Le client garantit qu'il est pleinement habilité à utiliser
        la carte de paiement pour le paiement de sa commande.</p>
    </section>

    <section>
      <h3 class="section-title">Livraison</h3>
      <p>Les produits sont livrés à l'adresse indiquée par le client lors de la commande. Les délais de livraison sont
        donnés à titre indicatif et {{ COMPANY_NAME }} ne pourra être tenu responsable des retards de livraison.</p>
    </section>

    <section>
      <h3 class="section-title">Droit de rétractation</h3>
      <p>Conformément à la législation en vigueur, le client dispose d'un délai de rétractation de 14 jours à compter de
        la réception des produits pour exercer son droit de rétractation, sans avoir à justifier de motifs ni à payer de
        pénalités.</p>
    </section>

    <section>
      <h3 class="section-title">Responsabilité</h3>
      <p>{{ COMPANY_NAME }} ne saurait être tenu pour responsable des dommages directs ou indirects causés par
        l'utilisation des produits vendus.</p>
    </section>

    <section>
      <h3 class="section-title">Litiges</h3>
      <p>En cas de litige, une solution amiable sera recherchée. À défaut, les tribunaux français seront seuls compétents.
      </p>
    </section>

    <section>
      <h3 class="section-title">Modification des conditions générales de vente</h3>
      <p>Les présentes conditions générales de vente peuvent être modifiées à tout moment par {{ COMPANY_NAME }}. Les
        conditions applicables sont celles en vigueur à la date de la commande.</p>
    </section>

  </div>
</template>

<script setup>
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { FRONT_URL, COMPANY_NAME } from '@/config';

</script>

<style scoped></style>
