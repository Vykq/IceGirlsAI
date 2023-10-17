import getImage from "./get-image";
import upscaleImage from "./upscale-image";
import isPremium from "./is-premium";

const upscaleSingleImage = () => {

    const button = document.querySelector('.upscale-single-image');
    let premiumBody = false;
    button.addEventListener('click', async (e) => {
        e.preventDefault();
        if(document.querySelector('body').classList.contains('premium')){
            premiumBody = true;
            button.textContent = "Upscaling...";
        } else {
            premiumBody = false;
            const modal = document.querySelector('.premium-modal');
            modal.classList.add('show');
        }

        console.log(button.dataset.id);
        const image = await getImage(button.dataset.id);
        if(image.image){
            console.log(image.image);
            const upscaledImage = await upscaleImage(premiumBody, image.image)
            if(upscaledImage) {
                button.disabled = true;
                button.textContent = "Upscaled";
            }
        }
    })

}

export default upscaleSingleImage;