const onPageLoad = () => {
    getLangPage();
}
const getLangPage = () => {
    console.log('hello')
    fetch("lang/fr.json")
        .then(response => response.json())
        .then(json => {
            console.log(json)
            for (var i in json) {
                var key = i;
                var val = json[i];
                let page = document.querySelector('#page');

                let option = document.createElement('option');
                option.innerHTML = key;

                page.appendChild(option);

            }
            getLangWord();
        });

}
const getLangWord = () => {
    let page = document.querySelector('#page').value;

    fetch("lang/fr.json")
        .then(response => response.json())
        .then(json => {
            console.log(json[page])
            for (let key in json[page]) {
                let page = document.querySelector('#word');
                let option = document.createElement('option');
                option.innerHTML = key;
                page.appendChild(option);

                let pageVal = document.querySelector('#page').value;
                let wordVal = document.querySelector('#word').value;
                let valuefr = document.querySelector('#fr');
                valuefr.value = json[pageVal][wordVal];

                fetch('lang/en.json')
                    .then(response => response.json())
                    .then(json => {
                        let valueEn = document.querySelector('#en');
                        valueEn.value = json[pageVal][wordVal];
                    });
            }
        });

}
const editLang = () => {

    let pageVal = document.querySelector('#page').value;
    let wordVal = document.querySelector('#word').value;
    let valuefr = document.querySelector('#fr').value;
    let valueen = document.querySelector('#en').value;

    let formData = new FormData();

    formData.append('page', pageVal);
    formData.append('word', wordVal);
    formData.append('fr', valuefr);
    formData.append('en', valueen);

    fetch("ajax/edit-text-ajax.php", {
        method: "POST",
        credentials: 'include',
        body: formData
    })

}