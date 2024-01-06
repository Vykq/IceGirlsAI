import getImage from "./get-image";
import upscaleImage from "./upscale-image";
import isPremium from "./is-premium";
import checkIfPremium from "../check-if-premium";

const upscaleSingleImage = () => {

    const button = document.querySelector('.upscale-single-image');
    let premiumBody = false;
    button.addEventListener('click', async (e) => {
        e.preventDefault();
        if(checkIfPremium()){
            premiumBody = true;
            button.textContent = "Upscaling...";

            const image = document.querySelector('.hub-single-image').src;
            if(image){
                console.log(image);
                const upscaledImage = await upscaleImage(premiumBody, image)
                if(upscaledImage) {
                    button.disabled = true;
                    button.textContent = "Upscaled";
                }
            }
        } else {
            premiumBody = false;
            const modal = document.querySelector('.premium-modal');
            modal.classList.add('show');
        }


    })

}

export default upscaleSingleImage;