<template>
      <div>
            <h2 class="page-title">Contactez nous !</h2>
            <Breadcrumb />
            <div class="contact-form">
                  <div class="form-split-half">
                        <div class="form-group my-4">
                              <label for="email" class="hidden">E-mail</label>
                              <input type="text" id="email" name="email" placeholder="E-mail" v-model="email" />
                        </div>
                        <div class=" form-group">
                              <label for="subject" class="hidden">Sujet</label>
                              <input type="text" id="subject" name="subject" placeholder="Sujet" v-model="subject" />
                        </div>
                  </div>
                  <div class="form-group my-4">
                        <label for="message" class="hidden">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Message"
                              v-model="message"></textarea>
                  </div>
                  <div class="checkbox-group">
                        <input type="checkbox" id="collectData" name="collectData" v-model="collectData" />
                        <label for="collectData">En cochant cette case, j'accepte que mes données soient collectées et
                              exploitées par {{ SITE_NAME }}. Pour plus d'informations, consultez nos <router-link
                                    to="/mentions-legales" class="link">mentions légales</router-link>.</label>
                  </div>

                  <div class="form-actions">
                        <button class="button" @click="sendForm()">Envoyer</button>
                  </div>
            </div>
      </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { notify } from '@/helpers/notif.js'
import Breadcrumb from '@/components/BreadcrumbComponent.vue'
import { isValidEmail } from '@/helpers/helpers.js'
import router from "@/router";
import { post } from '@/helpers/api';
import { useAuthStore } from '@/stores/auth'
import { SITE_NAME } from '@/config';
import { useRoute } from "vue-router";

const authStore = useAuthStore()
const route = useRoute()

const email = ref('');
const subject = ref('');
const message = ref('');
const collectData = ref(false);
const customer_id = ref(null);

function valid() {
      // return false; // ? uncomment this line to enable form validation
      if (!email.value || !subject.value || !message.value) return "Veuillez remplir tous les champs";
      if (!collectData.value && !authStore.authenticated) return "Veuillez accepter la collecte de données ou vous connecter";
      if (!isValidEmail(email.value)) return "Veuillez entrer une adresse e-mail valide";
      if (subject.value.length < 3) return "Le sujet doit contenir au moins 3 caractères";
      if (message.value.length < 10) return "Le message doit contenir au moins 10 caractères";
      return false;
}

async function sendForm() {
      const error = valid();
      if (error) {
            notify(error, 'error');
      } else {
            if (authStore.authenticated && authStore.user) customer_id.value = authStore.user.customer_id;
            const resp = await post('contact', { email: email.value, subject: subject.value, message: message.value, customer_id: JSON.stringify(customer_id.value) });
            if (!resp) {
                  notify('Erreur de connexion au serveur', 'error');
            } else if (resp.status == 'error') {
                  notify(resp.message, 'error');
            } else {
                  notify('Demande de contact envoyé !', 'success');
                  email.value = '';
                  subject.value = '';
                  message.value = '';
                  router.push('/');
            }
      }
}

onMounted(() => {

      // If user is authenticated, fill the email field with the user email
      if (authStore.authenticated && authStore.user) {
            document.querySelector(`label[for="email"]`).classList.remove('hidden'); // Trigger the label animation
            email.value = authStore.user.email;
      }

      // If sujet in the query params, fill the subject field
      if (route.query && route.query.sujet) {
            document.querySelector(`label[for="subject"]`).classList.remove('hidden'); // Trigger the label animation
            subject.value = route.query.sujet;
      }

      // All mounted for fancy animation
      const fieldsId = ['subject', 'email', 'message'];

      fieldsId.forEach(fieldId => { // for each field id of the array
            const input = document.getElementById(fieldId); // get the input element by id
            input.addEventListener("input", function () {
                  const associatedLabel = document.querySelector(`label[for="${this.id}"]`); // get the label associated with the input
                  if (associatedLabel) { // if the label exists
                        if (this.value == "") { // if the input is empty
                              associatedLabel.classList.add('hidden');
                              this.placeholder = associatedLabel.textContent; // put the label text in the placeholder
                        } else { // if the input is not empty
                              associatedLabel.classList.remove('hidden');
                              this.placeholder = ""; // Remove the placeholder since label is now displayed
                        }
                  }
            });
      });
});

</script>

<style scoped>
.contact-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      max-width: 500px;
      min-height: 50vh;
      margin: 0 auto;
}

.contact-form {
      display: flex;
      gap: 1rem;
}

label {
      color: var(--dark);
      font-weight: 600;
      transition: all 0.3s;
}

label.hidden {
      transform: translateY(39px) translateX(17px);
      opacity: 0;
}

::placeholder {
      color: var(--dark);
      font-weight: 600;
      opacity: 1 !important;
}
</style>