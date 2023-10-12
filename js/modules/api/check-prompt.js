const checkPrompt = async (wordArray) => {
    // Define the URL of your words.txt file hosted on your WordPress server
    const wordsFileUrl = themeUrl.themeUrl + '/words.txt';


    const postData = async (url, data) => {
        let res = await fetch(url, {
            method: 'GET',
            credentials: 'same-origin',
            body: data,
        });

        return await res; // Parse the response as JSON
    }


    return postData(wordsFileUrl)
        .then(response => response.text())
        .then(wordList => {
            //console.log(wordList);
            const predefinedWords = wordList.split('\n');
            const sanitizedWords = predefinedWords.map(word => word.replace(/\r/g, '').trim().toLowerCase());
            const matchingWords = wordArray.filter(word => sanitizedWords.includes(word.toLowerCase()));
                if (matchingWords.length > 0) {
                    const response = false;
                    return  { response, matchingWords };
                } else {
                    return true;
                }
            })
        .catch((error) => {
            console.log(error);
        });

}

export default checkPrompt;