
const apiCall = async (imageSize) => {

    if(imageSize.width === 0 || imageSize.height === 0 ) {
        const modal = document.querySelector('.no-image-undresser');
        modal.classList.add('show');
    } else {
        const myHeaders = new Headers();
        myHeaders.append("accept", "application/json");
        myHeaders.append("Content-Type", "application/json");
        const imageInput = document.querySelector('#dressed-photo');

        async function getImage64(input) {
            return new Promise((resolve, reject) => {
                var file = input.files[0];
                var reader = new FileReader();
                reader.onloadend = function() {
                    resolve(reader.result);
                };
                reader.onerror = function() {
                    reject(reader.error);
                };
                reader.readAsDataURL(file);
            });
        }

        try {
            const base64Image = await getImage64(imageInput);
            console.log(base64Image);


        let raw = {
            // "prompt": "((best quality)), absurdres, ((ultra high res)), ((masterpiece, best quality)), (4k, RAW photo, best quality, depth of field, ultra high res:1.1) naked man",
            "prompt": "((best quality)), absurdres, ((ultra high res)), ((masterpiece, best quality)), (4k, RAW photo, best quality, depth of field, ultra high res:1.1) naked man",
            "width": imageSize.width,
            "height": imageSize.height,
            "denoising_strength" : 1,
            "negative_prompt": "cartoon, painting, illustration, (worst quality, low quality, normal quality:2)",
            "init_images": [
                base64Image
            ],
            "override_settings": ({
                "sd_model_checkpoint" : 'juggernaut_final',
            }),
            "sampler_name": 'DPM++ 2M Karras',
            "sampler_index": 'DPM++ 2M Karras',
            "cfg_scale" : 6,
            "steps": 20,
            "n_iter": 1,
            "seed": -1,
            "restore_faces": false,
            "tiling": false,
            "firstpass_image": base64Image,
            "image_cfg_scale": 7,
            "checkpoint" : 'juggernaut_final',
            "alwayson_scripts" : {
                "controlnet" : {
                    "args": [
                        {
                            "input_image": base64Image,
                            "module": "openpose_full",
                            "model": "control_v11p_sd15_openpose [cab727d4]"
                        }
                    ]
                },
                "a person mask generator": {
                    "args": [
                        true,
                        [
                            "clothes"
                        ],
                        true,
                        4,
                        0,
                        1,
                        0,
                        256,
                        8,
                        8
                    ]
                }
            }
            // "initial_noise_multiplier" : 0,
            // "inpaint_full_res" : 0,
            // "inpaint_full_res_padding" : 32,
            // "inpainting_fill" : 1,
            // "inpainting_mask_invert" : 0,
            // "mask_blur" : 4,
            // "mask_blur_x" : 4,
            // "mask_blur_y" : 4,
            // "mask_round" : true,
            // "n_iter" : 1,
        };

        let maskExtensionArgs = [
            true,
            [
                "clothes"
                // "face (skin)"
            ],
            true,
            4,
            0,
            1,
            0,
            256,
            8,
            8
        ];

        // let controlNetOpenPose = {
        //     "0": [
        //         null, //"advanced_weighting" :
        //         "", //"batch_images" :
        //         "ControlNet is more important", //"control_mode" :
        //         true, // "enabled" :
        //         1, //"guidance_end" :
        //         0, //"guidance_start" :
        //         "Both", //"hr_option" :
        //         base64Image, //"image" :
        //         true, //"inpaint_crop_input_image" :
        //         "simple", //"input_mode" :
        //         false, //"is_ui" :
        //         false, //"loopback" :
        //         true, //"low_vram" :
        //         "control_v11p_sd15_openpose [cab727d4]", //"model" :
        //         "openpose_full", //"module" :
        //         "", //"output_dir" :
        //         true, //"pixel_perfect" :
        //         512, //"processor_res" :
        //         "Crop and Resize", //"resize_mode" :
        //         true, //"save_detected_map" :
        //         -1, //"threshold_a" :
        //         -1, //"threshold_b" :
        //         1 //"weight" :
        //     ]
        // };

            let controlNetOpenPose = {
                "input_image": base64Image,
                "module": "openpose_full",
                "model": "control_v11p_sd15_openpose [cab727d4]"
            };

            // raw['alwayson_scripts'] = {
            //     // "a person mask generator": {
            //     //     "args": maskExtensionArgs
            //     // },
            //     "controlnet": {
            //         "args": controlNetOpenPose
            //     }
            // };

        const requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: JSON.stringify(raw),
            redirect: 'follow',
            referrerPolicy: "unsafe-url",
        };

        let apiUrl = themeUrl.apiUrl;


        return fetch(apiUrl + "agent-scheduler/v1/queue/img2img", requestOptions)
            .then(response => response.json())
            .then(data => {
                return {
                    task_id: data.task_id, // Return task_id
                    //raw: JSON.parse(raw), // Return the raw object
                };
            })
            .catch(error => console.error('error', error));

        } catch (error) {
            console.error('Error reading image:', error);
        }


    }

    console.log(imageSize);

}

export default apiCall;