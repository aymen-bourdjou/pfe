<!-- LISTE INVENTAIRE-->

<script setup>

</script>



<template>
    <div class="grid">
        
        <form action="thank-you.html">
      <h2>Nouvelle équipe</h2>

      <div class="form-group email">
        <label for="email">Nom equipe</label>
        <input type="text" id="email">
      </div>
      
      <div class="form-group gender">
        <label for="gender">Nom inventaire</label>
        <select id="gender">
          <option value="" selected disabled>Selectionnez l'inventaire</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <div class="form-group gender">
        <label for="gender">Nom comptage</label>
        <select id="gender">
          <option value="" selected disabled>Selectionnez le comptage</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>
      
      <div class="form-group submit-btn">
        <input type="submit" value="Valider">
      </div>
     </form>



        <div class="col-12">
            <div class="card">
                
                <DataTable :value="products" v-model:expandedRows="expandedRows" dataKey="id" tableStyle="min-width: 60rem">
                    <template #header>
                        <div>
                            <Button icon="pi pi-plus" label="Créer" @click="expandAll" class="mr-2 mb-2" />
                        </div>
                        <div>
                            <Button icon="pi pi-plus" label="Affectation" @click="expandAll" class="mr-2 mb-2" />
                        </div>
                    </template>
                    <Column :expander="true" headerStyle="width: 3rem" />
                    <Column field="ID" header="ID" :sortable="true">
                        <template #body="slotProps">
                            {{ slotProps.data.name }}
                        </template>
                    </Column>

                    <Column field="ID comptage" header="ID comptage" :sortable="true">
                        <template #body="slotProps">
                            {{ slotProps.data.name }}
                        </template>
                    </Column>


                    <Column field="Nom equipe" header="Nom equipe" :sortable="true">
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.price) }}
                        </template>
                    </Column>
                
                    <Column field="Date début " header="Date début" :sortable="true">
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.price) }}
                        </template>
                    </Column>
                    <Column field="Date fin" header="Date fin" :sortable="true">
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.category) }}
                        </template>
                    </Column>
                  
                    <Column field="Action" header="Action" :sortable="true">
                        <template #body="slotProps">
                            <Tag :severity="getBadgeSeverity(slotProps.data.inventoryStatus)">{{ slotProps.data.inventoryStatus }}</Tag>
                        </template>
                    </Column>

                    
                   
                </DataTable>
            </div>
        </div>

    </div>
</template>

<style scoped lang="scss">
:deep(.p-datatable-frozen-tbody) {
    font-weight: bold;
}

:deep(.p-datatable-scrollable .p-frozen-column) {
    font-weight: bold;
}


</style>

<style scoped lang="scss">
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Open Sans', sans-serif;
}
body {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 10px;
  min-height: 100vh;
  background: #1BB295;
}
form {
  padding: 25px;
  background: #fff;
  max-width: 500px;
  width: 100%;
  border-radius: 7px;
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05);
}
form h2 {
  font-size: 27px;
  text-align: center;
  margin: 0px 0 30px;
}
form .form-group {
  margin-bottom: 15px;
  position: relative;
}
form label {
  display: block;
  font-size: 15px;
  margin-bottom: 7px;
}
form input,
form select {
  height: 45px;
  padding: 10px;
  width: 100%;
  font-size: 15px;
  outline: none;
  background: #fff;
  border-radius: 3px;
  border: 1px solid #bfbfbf;
}
form input:focus,
form select:focus {
  border-color: #9a9a9a;
}
form input.error,
form select.error {
  border-color: #f91919;
  background: #f9f0f1;
}
form small {
  font-size: 14px;
  margin-top: 5px;
  display: block;
  color: #f91919;
}
form .password i {
  position: absolute;
  right: 0px;
  height: 45px;
  top: 28px;
  font-size: 13px;
  line-height: 45px;
  width: 45px;
  cursor: pointer;
  color: #939393;
  text-align: center;
}
.submit-btn {
  margin-top: 30px;
}
.submit-btn input {
  color: white;
  border: none;
  height: auto;
  font-size: 16px;
  padding: 13px 0;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 500;
  text-align: center;
  background: #1BB295;
  transition: 0.2s ease;
}
.submit-btn input:hover {
  background: #179b81;
}
</style>