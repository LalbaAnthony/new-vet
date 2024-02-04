<template>
      <div>
            <h2 class="page-title">Contactez nous !</h2>
            <div class="contact-form">
                  <div class="split-half">
                        <div class="form-group">
                              <label for="email" class="hidden">E-mail</label>
                              <input type="text" id="email" name="email" placeholder="E-mail" v-model="email" />
                        </div>
                        <div class=" form-group">
                              <label for="subject" class="hidden">Sujet</label>
                              <input type="text" id="subject" name="subject" placeholder="Sujet" v-model="subject" />
                        </div>
                  </div>
                  <div class="form-group">
                        <label for="message" class="hidden">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Message" v-model="message"></textarea>
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
import { isValidEmail } from '@/helpers/helpers.js'
import router from "@/router";

const email = ref('zez');
const subject = ref('');
const message = ref('');

function formError() {
      if (!email.value || !subject.value || !message.value) return "Veuillez remplir tous les champs";
      if (!isValidEmail(email.value)) return "Veuillez entrer une adresse e-mail valide";
      if (subject.value.length < 3) return "Le sujet doit contenir au moins 3 caractères";
      if (message.value.length < 10) return "Le message doit contenir au moins 10 caractères";
      return false;
}

function sendForm() {
      const error = formError();
      if (error) {
            notify(error, 'error');
      } else {
            // ... send the form
            notify('Demande de contact envoyé !', 'success');
            router.push('/');
      }
}

onMounted(() => {
      // All mounted for fancy animation
      const fieldsId = ['subject', 'email', 'message'];

      fieldsId.forEach(fieldId => { // for each field id of the array
            const input = document.getElementById(fieldId); // get the input element by id
            input.addEventListener("input", function () {
                  const associatedLabel = document.querySelector(`label[for="${this.id}"]`); // get the label associated with the input
                  if (associatedLabel) { // if the label exists
                        if (this.value == "") { // if the input is empty
                              console.log('empty');
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
/* DESKTOP */
@media (min-width: 1024px) {
      .contact-form .split-half {
            flex-direction: row;
      }

}

/* TABLET */
@media (min-width: 768px) and (max-width: 1023px) {
      .contact-form .split-half {
            flex-direction: row;
      }

}

/* MOBILE */
@media (max-width: 767px) {
      .contact-form .split-half {
            flex-direction: column;
      }

}

.contact-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
      max-width: 500px;
      margin: 0 auto;
}

.contact-form .split-half {
      display: flex;
      gap: 1rem;
}

.contact-form .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
}


.contact-form .form-actions {
      display: flex;
      justify-content: center;
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
      opacity: 1 !important;
}
</style>
