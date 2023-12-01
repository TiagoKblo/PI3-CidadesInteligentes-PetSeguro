let animalInfoDiv;
let animalIcon;
// Função de geocodificação para obter a latitude e longitude com base no endereço
function geocodeAddress(address, callback) {
    const geocoder = new google.maps.Geocoder();

    // Note que não estamos passando a chave da API aqui, pois já está incluída no script do Google Maps no HTML
    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status === 'OK') {
            const location = results[0].geometry.location;
            const latLng = { lat: location.lat(), lng: location.lng() };
            callback(latLng);
        } else {
            console.error('Erro ao geocodificar o endereço:', status);
        }
    });
}
function initMap() {
    // Use a Geocoding API para obter as coordenadas para "Itapira, SP, Brasil"
    const geocoder = new google.maps.Geocoder();
    const location = "Itapira, SP, Brasil";

    geocoder.geocode({ 'address': location }, function (results, status) {
        if (status === 'OK') {
            const myLatLng = results[0].geometry.location;
            const map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 11
            });

            // Ícone da cidade
            const cityIconSize = new google.maps.Size(20, 20);

            // Crie um objeto de ícone para a cidade com a propriedade scaledSize definida
            const cityIcon = {
                url: '/imagens/icone-cidade.png',
                scaledSize: cityIconSize
            };

            new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: location,
                icon: cityIcon
            });

            // Carregue e exiba os polígonos do GeoJSON
            loadGeoJson(map);

            // Adicione marcadores de animais perdidos
            loadLostPetsMarkers(map);
        } else {
            console.error('Erro ao obter coordenadas:', status);
        }
    });
}

function loadGeoJson(map) {
    // Carregue o arquivo GeoJSON (itapira.json)
    map.data.loadGeoJson('itapira.json');

    // Defina estilos para os polígonos
    map.data.setStyle({
        fillColor: 'green',
        strokeWeight: 1
    });
}



// Função para carregar marcadores de animais perdidos no mapa a partir de um arquivo JSON
function loadLostPetsMarkers(map) {
    const jsonFilePath = 'dados_animais.json';

    fetch(jsonFilePath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar dados do arquivo JSON');
            }
            return response.json();
        })
        .then(data => {
            const lostPetsData = data.filter(animal => animal['animal-perdido'] === 'sim');

            const animalIconSize = new google.maps.Size(25, 25);
            const animalIcon = {
                url: '/imagens/icone-pata.png',
                scaledSize: animalIconSize
            };

            lostPetsData.forEach(function (animal) {
                const fixedAddress = `${animal.rua}, ${animal.numero}, ${animal.bairro}, ${animal.cidade}, ${animal.estado}, ${animal.cep}`;

                geocodeAddress(fixedAddress, function (latLng) {
                    const marker = new google.maps.Marker({
                        position: latLng,
                        map: map,
                        title: animal.nome,
                        icon: animalIcon
                    });

                    // Adicione um infowindow ao marcador
                    const infowindow = new google.maps.InfoWindow();

                    marker.addListener('mouseover', function () {
                        infowindow.setContent(fixedAddress); // Configura o conteúdo do infowindow
                        infowindow.open(map, marker);
                    });

                    marker.addListener('mouseout', function () {
                        infowindow.close();
                    });

                    marker.addListener('click', function () {
                        showAnimalInfo(animal);
                    });
                });
            });
        })
        .catch(error => console.error(error.message));
}

function showAnimalInfo(animal) {
    // Exibir informações básicas
    document.getElementById('animal-name').innerText = animal.nome;
    document.getElementById('animal-breed').innerText = animal.raca;
    document.getElementById('animal-color').innerText = animal.cor;

    // Exibir informações adicionais
    document.getElementById('animal-chipped').innerText = animal['possui-microchip'];
    document.getElementById('animal-vaccinated').innerText = animal['animal-vacinado'];
    document.getElementById('owner-name').innerText = animal['nome-proprietario'];
    // Adicione mais campos conforme necessário
}
