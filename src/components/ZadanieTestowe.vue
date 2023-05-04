<template>
  <v-data-table :headers="headers" :items="desserts" sort-by="no" class="elevation-1" :items-per-page="3">
    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title>Samochody</v-toolbar-title>
        <v-divider class="mx-4" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">New Item</v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="text-h5">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.registration_number" label="Numer rejestracyjny"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.car_brand" label="Marka"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.car_model" label="Model"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.ctime" label="Data utworzenia"></v-text-field>
                  </v-col>
                  <v-col cols="12" sm="6" md="4">
                    <v-text-field v-model="editedItem.mtime" label="Data modyfikacji"></v-text-field>
                  </v-col>
                </v-row>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="save">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:[`item.actions`]="{ item }">
      <v-icon small class="mr-2" @click="editItem(item)">mdi-pencil</v-icon>
      <v-icon small @click="deleteItem(item)">mdi-delete</v-icon>
    </template>
    <template v-slot:no-data>
      <v-btn color="primary" @click="initialize">Reset</v-btn>
    </template>
  </v-data-table>
</template>

<script>

import axios from "axios";
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    headers: [
      {text: 'Lp.', align: 'start', value: 'no'},
      {text: 'Numer rejestracyjny', value: 'registration_number'},
      {text: 'Marka', value: 'car_brand'},
      {text: 'Model', value: 'car_model'},
      {text: 'Data utworzenia', value: 'ctime'},
      {text: 'Data modyfikacji', value: 'mtime'},
      {text: 'Actions', value: 'actions', sortable: false},
    ],
    desserts: [],
    editedIndex: -1,
    editedItem: {
      registration_number: '',
      car_brand: '',
      car_model: '',
      ctime: '',
      mtime: '',
    },
    defaultItem: {
      no: '0',
      registration_number: '',
      car_brand: '',
      car_model: '',
      ctime: '',
      mtime: '',
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
    },
  },

  watch: {
    dialog(val) {
      val || this.close()
    },
    dialogDelete(val) {
      val || this.closeDelete()
    },
  },

  created() {
    this.indexList()
  },

  methods: {
    initialize() {
      this.desserts = this.indexList()
      //     [
      //   {
      //     no: 1,
      //     registration_number: 'Frozen Yogurt',
      //     car_brand: 159,
      //     car_model: 6.0,
      //     ctime: 24,
      //     mtime: 4.0,
      //   },
      //   {
      //     no: 2,
      //     registration_number: 'Ice cream sandwich',
      //     car_brand: 237,
      //     car_model: 9.0,
      //     ctime: 37,
      //     mtime: 4.3,
      //   },
      //   {
      //     no: 3,
      //     registration_number: 'Eclair',
      //     car_brand: 262,
      //     car_model: 16.0,
      //     ctime: 23,
      //     mtime: 6.0,
      //   },
      //   {
      //     no: 4,
      //     registration_number: 'Cupcake',
      //     car_brand: 305,
      //     car_model: 3.7,
      //     ctime: 67,
      //     mtime: 4.3,
      //   },
      //   {
      //     no: 5,
      //     registration_number: 'Gingerbread',
      //     car_brand: 356,
      //     car_model: 16.0,
      //     ctime: 49,
      //     mtime: 3.9,
      //   },
      //   {
      //     no: 6,
      //     registration_number: 'Jelly bean',
      //     car_brand: 375,
      //     car_model: 0.0,
      //     ctime: 94,
      //     mtime: 0.0,
      //   },
      //   {
      //     no: 7,
      //     registration_number: 'Lollipop',
      //     car_brand: 392,
      //     car_model: 0.2,
      //     ctime: 98,
      //     mtime: 0,
      //   },
      //   {
      //     no: 8,
      //     registration_number: 'Honeycomb',
      //     car_brand: 408,
      //     car_model: 3.2,
      //     ctime: 87,
      //     mtime: 6.5,
      //   },
      //   {
      //     no: 9,
      //     registration_number: 'Donut',
      //     car_brand: 452,
      //     car_model: 25.0,
      //     ctime: 51,
      //     mtime: 4.9,
      //   },
      //   {
      //     no: 10,
      //     registration_number: 'KitKat',
      //     car_brand: 518,
      //     car_model: 26.0,
      //     ctime: 65,
      //     mtime: 7,
      //   },
      // ]
    },

    indexList () {
      axios.get('http://fabian', {

      }).then(function (response) {
        console.log(response.data);

        return response.data;
      });

    },

    editItem(item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialog = true
    },

    deleteItem(item) {
      this.editedIndex = this.desserts.indexOf(item)
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm() {
      this.desserts.splice(this.editedIndex, 1)
      this.closeDelete()
    },

    close() {
      this.dialog = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete() {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.desserts[this.editedIndex], this.editedItem)
      } else {
        this.desserts.push(this.editedItem)
      }
      this.close()
    },
  },
}
</script>