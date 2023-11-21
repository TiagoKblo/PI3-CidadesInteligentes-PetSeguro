function addLostPet() {
  const petName = document.getElementById('pet-name').value;
  const petDescription = document.getElementById('pet-description').value;

  if (movableMarker) {
      const petLatLng = movableMarker.getPosition();

      // Adicione um marcador para a localização do animal perdido
      new google.maps.Marker({
          position: petLatLng,
          map: map,
          title: petName
      });

      // Aqui você pode armazenar as informações do animal perdido no seu banco de dados ou em outra estrutura de dados
      // Exemplo: petDatabase.addLostPet(petName, petDescription, petLatLng);

      // Limpe o formulário após o cadastro
      document.getElementById('pet-name').value = '';
      document.getElementById('pet-description').value = '';

      // Remova o marcador móvel
      movableMarker.setMap(null);
      movableMarker = null;
  } else {
      alert('Escolha a localização do animal no mapa.');
  }
}
