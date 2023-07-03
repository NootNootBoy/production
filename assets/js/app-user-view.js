/**
 * App User View - Suspend User Script
 */
'use strict';

(function () {
  const suspendUser = document.querySelector('.suspend-user');

  // Suspend User javascript
  if (suspendUser) {
    suspendUser.onclick = function () {
      Swal.fire({
        title: 'Êtes-vous sur ?',
        text: "Le statut du client sera archivé",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, confirmer !',
        customClass: {
          confirmButton: 'btn btn-primary me-2',
          cancelButton: 'btn btn-label-secondary'
        },
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
          Swal.fire({
            icon: 'success',
            title: 'Archivé!',
            text: 'le client vient d\'être archivé.',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Annulé',
            text: 'Archivage annulé :)',
            icon: 'error',
            customClass: {
              confirmButton: 'btn btn-success'
            }
          });
        }
      });
    };
  }

  //? Billing page have multiple buttons
  // Cancel Subscription alert
  const cancelSubscription = document.querySelectorAll('.cancel-subscription');

  // Alert With Functional Confirm Button
  if (cancelSubscription) {
    cancelSubscription.forEach(btnCancle => {
      btnCancle.onclick = function () {
        Swal.fire({
          text: 'Are you sure you would like to cancel your subscription?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-label-secondary'
          },
          buttonsStyling: false
        }).then(function (result) {
          if (result.value) {
            Swal.fire({
              icon: 'success',
              title: 'Unsubscribed!',
              text: 'Your subscription cancelled successfully.',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
              title: 'Cancelled',
              text: 'Unsubscription Cancelled!!',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      };
    });
  }
})();
