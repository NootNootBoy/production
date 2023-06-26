/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          username: {
            validators: {
              notEmpty: {
                message: 'Entrer votre pseudonyme'
              },
              stringLength: {
                min: 6,
                message: 'Pseudonyme doit faire plus de 6 caractères'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Entrer votre adresse mail'
              },
              emailAddress: {
                message: 'Entrer une adresse mail valide'
              }
            }
          },
          'email-username': {
            validators: {
              notEmpty: {
                message: 'Entrer votre email / pseudonyme'
              },
              stringLength: {
                min: 6,
                message: 'Le pseudonyme doit comporter plus de 6 caractères'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Please enter your password'
              },
              stringLength: {
                min: 6,
                message: 'Le mot de passe doit comporter plus de 6 caractères'
              }
            }
          },
          'confirm-password': {
            validators: {
              notEmpty: {
                message: 'Confirmer votre mot de passe'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Le mot de passe et sa confirmation ne sont pas les mêmes'
              },
              stringLength: {
                min: 6,
                message: 'Le mot de passe doit comporter plus de 6 caractères'
              }
            }
          },
          terms: {
            validators: {
              notEmpty: {
                message: 'Veuillez accepter les termes et conditions'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }

    //  Two Steps Verification
    const numeralMask = document.querySelectorAll('.numeral-mask');

    // Verification masking
    if (numeralMask.length) {
      numeralMask.forEach(e => {
        new Cleave(e, {
          numeral: true
        });
      });
    }
  })();
});
