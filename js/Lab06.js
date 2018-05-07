(function () {
    const itemNum = countries.length;
    const container = document.getElementsByClassName("flex-container");
    for (let i = 0; i < itemNum; i++){
        const item = document.createElement("div");
        item.setAttribute("class","item");

        const country = document.createElement("h2");
        country.appendChild(document.createTextNode(countries[i].name));
        const continent = document.createElement("p");
        continent.appendChild(document.createTextNode(countries[i].continent));

        const div_cities = document.createElement("div");
        div_cities.setAttribute("class","inner-box");
        const citiesH3 = document.createElement("h3");
        citiesH3.appendChild(document.createTextNode("Cities"));
        div_cities.appendChild(citiesH3);
        for (let k = 0; k < countries[i].cities.length;k++){
            const citiesName = document.createElement("p");
            citiesName.appendChild(document.createTextNode(countries[i].cities[k]));
            div_cities.appendChild(citiesName);
        }

        const div_photo = document.createElement("div");
        div_photo.setAttribute("class","inner-box");
        const photoH3 = document.createElement("h3");
        photoH3.appendChild(document.createTextNode("Popular Photos"));
        div_photo.appendChild(photoH3);
        for (let k = 0; k < countries[i].photos.length; k++){
            const photoItem = document.createElement("img");
            photoItem.setAttribute("class","photo");
            photoItem.setAttribute("src","images/"+countries[i].photos[k]);
            div_photo.appendChild(photoItem);
        }

        const bt_visit = document.createElement("button");
        bt_visit.appendChild(document.createTextNode("Visit"));
        bt_visit.setAttribute("class","justify");

        item.appendChild(country);
        item.appendChild(continent);
        item.appendChild(div_cities);
        item.appendChild(div_photo);
        item.appendChild(bt_visit);

        container[0].appendChild(item);
    }
})();