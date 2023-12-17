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
import hubPage from "./modules/hub-page";
import profilePage from "./modules/profile-page";
import ageVerification from "./modules/age-verification";
import closeMainModal from "./modules/close-main-modal";
import timer from "./modules/countdown-timer";
import accountPage from "./modules/account-page";
import singleImage from "./modules/single-image";
import testinis from "./modules/testinis";
import singleImageTwo from "./modules/single-image2";
import Splide from "../assets/splide.min";
import showTooltip from "./modules/show-tooltip";
import charsFilter from "./modules/chars-filter";
import setVideoObserver from "./modules/video-observer";
import cancelSubscription from "./modules/stripe/cancel-subscription";

window.addEventListener('DOMContentLoaded', async () => {
  document.querySelector('.site-loader').classList.add('hide');
  openModals();
  openModalOnLink();

  if(!document.querySelector('body').classList.contains('logged-in')){
    switchLoginRegister();
  }

  if(document.querySelector('.tooltip-icon')){
    showTooltip();
  }

  if (document.querySelector('video')) {
    setVideoObserver();
  }


  if(document.querySelector('.create-page-template')){
    apiTasks();
    showTabs();
    updateRangeValue();
    charsFilter('.single-filter', '.single-char')
  }

  if (document.querySelector('.main-modal-blur')) {
    closeMainModal();
    const popup = document.querySelector('.main-modal-blur');
    const html = document.querySelector('html');
    if(localStorage.getItem('premium-modal') === 'Off'){
      popup.classList.add('disabled');
    }
    else{
      setTimeout(function(){
        popup.classList.add('open');
        html.classList.add('modal-is-open');
        console.log('1');
      }, parseFloat(modal_timer*1000));
    }
      timer('.timer', deadline);
  }


  if(document.querySelector('.account-page-template')){
    profilePage();
  }

  if(document.querySelector('.single-generated-image-page')){
    singleImage();
  }

  if(document.querySelector('.single-image-id')){
    await singleImageTwo();
  }

  //if(document.querySelector('.generated-images-wrapper')){
  if(document.querySelector('.hub-page-template')){
    await hubPage();
  }

  if(document.querySelector('.last-creations-wrapper')){
    accountPage();
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

  // if(document.querySelector('.add-to-favorites')){
  //   likeImageAjax();
  // }
  // if(document.querySelector('.remove-from-favorites')){
  //   unlikeImageAjax();
  // }

  if(document.querySelector('.upscale-single-image')){
    upscaleSingleImage();
  }
  if(document.querySelector('.cancel-sub')) {
    cancelSubscription();
  }


  if (document.querySelector('.age-verification')) {
    ageVerification();
    const popup = document.querySelector('.age-verification');
    const html = document.querySelector('html');
    if(localStorage.getItem('age') === '18'){
      popup.classList.add('disabled');
    }
    else{
        popup.classList.add('show');
        html.classList.add('modal-is-open');
    }
  }



  if (document.querySelector('.featured-block')) {

    var elms = document.querySelectorAll( '.logo-slider' );


    for ( var i = 0; i < elms.length; i++ ) {
      const slider = new Splide( elms[ i ], {
        width: '100%',
        perPage: 3,
        gap: '1.5rem',
        pagination: false,
        arrows: true,
        focus  : 'center',
        breakpoints: {
          900: {
            perPage: 2,
            focus  : 'left',
          },
          700: {
            perPage: 1,
            gap: 0,
          },
        }
      } );
      slider.mount();

    }
  }




})