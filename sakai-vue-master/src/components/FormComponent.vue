<template>
    <div class="form-container">
      <form @submit.prevent="submitForm">
        <h2>Nouveau inventaire</h2>
      
      <div class="form-group date">
        <label for="date">Date</label>
        <input type="date" id="date" placeholder="Select your date">
      </div>

      <div class="form-group gender">
        <label for="gender">Département</label>
        <select id="gender">
        <option value="" selected disabled>Selectionnez le departement</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group gender">
        <label for="gender">Zone</label>
        <select id="gender">
          <option value="" selected disabled>Selectionnez la zone</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group email">
        <label for="email">Remarque</label>
        <input type="text" id="email">
      </div>

      <div class="form-group submit-btn">
        <input type="submit" value="Valider">
      </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, defineEmits } from 'vue';
  
  const name = ref('');
  const email = ref('');
  
  const emit = defineEmits(['close']);
  
  const submitForm = () => {
    alert(`Nom: ${name.value}, Email: ${email.value}`);
    emit('close');
  };
  
  const closeForm = () => {
    emit('close');
  };
  </script>
  
  <style>
  .form-container {
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 20px;
    background: white;
    border: 1px solid #ccc;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  </style>
  