import showTabs from "./modules/create-tabs";
import openModals from "./modules/open-modals";
import updateRangeValue from "./modules/update-range-value";
import apiTasks from "./modules/api/api-tasks";
import likeImageAjax from "./modules/like-image-ajax";
import unlikeImageAjax from "./modules/api/unlike-image-ajax";
import upscaleSingleImage from "./modules/api/upscale-single-image";
import openModalOnLink from "./modules/open-modal-on-link";
import switchLoginRegister from "./modules/switch-login-register";
import accordion from "./modules/accordions";
import sendRemovalForm from "./modules/send-form-removal";
import customSelect from "./modules/custom-select";
import sendContactForm from "./modules/send-form-contact";
//import hubPage from "./modules/hub-page";

window.addEventListener('DOMContentLoaded', () => {
  openModals();
  openModalOnLink();

  if(!document.querySelector('body').classList.contains('logged-in')){
    switchLoginRegister();
  }

  if(document.querySelector('.create-page-template')){
    apiTasks();
    showTabs();
    updateRangeValue();
  }

  if(document.querySelector('.hub-page-template')){
    //hubPage();
  }

  if(document.querySelector('form.content-removal')){
    sendRemovalForm();
  }

  if(document.querySelector('form.contact-support')){
    sendContactForm();
    customSelect();
  }

  if(document.querySelector('.faqs-block')){
    accordion();
  }

  if(document.querySelector('.add-to-favorites')){
    likeImageAjax();
  }
  if(document.querySelector('.remove-from-favorites')){
    unlikeImageAjax();
  }

  if(document.querySelector('.upscale-single-image')){
    upscaleSingleImage();
  }

})