import getCookie from "./getCookie";
import switchGenerateButton from "./api/switch-generate-button";
import isPremium from "./api/is-premium";
import apiGetQueue from "./api/api-get-queue";
import setPercent from "./api/set-percent";
import showQueueInfo from "./api/show-queue-info";
import getPosition from "./api/get-position";
import updateQueueInfo from "./api/update-queue-info";
import getSeed from "./api/get-seed";
import getImage from "./api/get-image";
import loadImage from "./api/load-image";
import createPost from "./api/create-post";
import setCookie from "./createCookie";
import getCookieValue from "./getCookieValue";

const checkIfCookieSet = () => {


    const lastID = getCookieValue('lastGeneratedId');

      if(lastID !== "") {
            return { success: true, id: lastID} ;
      } else {
          return false;
      }




}

export default checkIfCookieSet;