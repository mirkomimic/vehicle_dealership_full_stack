<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { Head, router, useForm, usePage } from '@inertiajs/vue3';
import { watch, computed, toRefs, ref, nextTick } from 'vue';
import { VDataTable } from 'vuetify/labs/VDataTable'

const props = defineProps(['brands'])
const { brands } = toRefs(props)

const rules = {
  required: value => !!value || 'The name field is required.',
}

const formTable = useForm({
  id: null,
  name: null,
  image: null,
})

// data table
const headers = [
  { title: 'ID', key: 'id' },
  { title: 'Name', key: 'name' },
  { title: 'Image', key: 'image', align: 'center' },
  { title: 'Actions', key: 'actions', sortable: false }
]
const dialogTable = ref(false)
const dialogDelete = ref(false)
const editedIndex = ref(-1)
const search = ref('')
const progressTextInput = ref(false)
const editedItem = ref({
  id: null,
  name: '',
  image: null
})
const defaultItem = ref({
  id: null,
  name: '',
  image: null
})

const formTitle = computed(() => {
  return editedIndex.value === -1 ? 'New Item' : 'Edit Item'
})

watch(dialogTable, (val) => {
  val || close()
})
watch(dialogDelete, (val) => {
  val || closeDelete()
})

const editItem = (item) => {
  formTable.id = item.id
  formTable.name = item.name

  editedIndex.value = brands.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogTable.value = true
}
const deleteItem = (item) => {
  editedIndex.value = brands.value.indexOf(item)
  editedItem.value = Object.assign({}, item)
  dialogDelete.value = true
}
const deleteItemConfirm = () => {
  // delete brand
  try {
    router.delete(route('dashboard.brands.delete', editedItem.value.id))
    
    setTimeout(() => {
      document.getElementById('successMsg').style.display = 'none'
      usePage().props.flash.success = null
    }, 3000);

  } catch (error) {
    console.log(error);
  }

  closeDelete()
}
const close = () => {
  dialogTable.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
    usePage().props.errors.name = null
    formTable.reset();
  })
}
const closeDelete = () => {
  dialogDelete.value = false
  nextTick(() => {
    editedItem.value = Object.assign({}, defaultItem.value)
    editedIndex.value = -1
  })
}
const save = () => {
  if (editedIndex.value > -1) {
   
    // edit brand
    try {

      formTable.post(route('dashboard.brands.update', formTable.id), {
        _method: 'put'
      });

      formTable.reset()

      progressTextInput.value = true

      setTimeout(() => {
        progressTextInput.value = false
        close()

      }, 2000)

      setTimeout(() => {
        document.getElementById('successMsg').style.display = 'none'
        usePage().props.flash.success = null

      }, 5000);

      
    } catch (error) {
      console.log(error);
    }
  } else {
    // add brand
    try {
      formTable.post(route('dashboard.brands.store'));
      formTable.reset()

      progressTextInput.value = true

      setTimeout(() => {
        progressTextInput.value = false
        close()

      }, 2000)

      setTimeout(() => {
        document.getElementById('successMsg').style.display = 'none'
        usePage().props.flash.success = null

      }, 5000);
    
    } catch (error) {
      console.log(error);
    }
  }
}
</script>

<template>
  <Head title="Dashboard | Brands" />

  <DashboardLayout>
    <div class="tw-h-full tw-relative">
      <!-- alert -->
      <div class="tw-w-[300px] tw-absolute tw-top-0 tw-right-0 tw-z-20 tw-mt-3">
        <v-fade-transition>
          <v-alert
            v-if="$page.props.flash.success"
            id="successMsg"
            closable
            icon="mdi-check"
            title="Message"
            :text="$page.props.flash.success"
            variant="flat"
            theme="light"
            color="rgba(33,250,182,0.7)"
            width="300"
          ></v-alert>
        </v-fade-transition>
      </div>
    </div>

    <!-- data table -->
    <div class="tw-w-full tw-overflow-x-auto">
      <div class="tw-w-[1000px]  tw-mx-auto tw-mt-10 tw-mb-3 tw-p-1 tw-border tw-border-[rgba(33,250,182,0.57)] tw-rounded-md">
      
        <v-data-table
          :headers="headers"
          :items="brands"
          :search="search"
        >
          <template v-slot:top>
            <v-toolbar
              flat
            >
              <v-toolbar-title>
                <template v-slot:text>
                  <v-text-field
                    v-model="search"
                    label="Search"
                    prepend-inner-icon="mdi-magnify"
                    single-line
                    variant="outlined"
                    hide-details
                    class="vuetifyInput"
                  ></v-text-field>
                </template>
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-dialog
                v-model="dialogTable"
                max-width="500px"
              >
                <template v-slot:activator="{ props }">
                  <v-btn
                    color="teal-lighten-3"
                    dark
                    variant="outlined"
                    class=""
                    v-bind="props"
                  >
                    New Brand
                  </v-btn>
                </template>
                <v-card>

                  <v-progress-linear
                    :active="progressTextInput"

                    color="teal-darken-3"
                    height="7"
                    indeterminate
                  ></v-progress-linear>

                  <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                  </v-card-title>
                  <v-card-text>
                    <v-container>
                      <v-row>
                        <v-col
                          cols="12"
                        >
                          <v-text-field
                            v-model="formTable.name"
                            :rules="[rules.required]"
                            :error-messages="$page.props.errors.name"
                            label="Name"
                            class="vuetifyInput"
                          >
                          </v-text-field>
                        </v-col>
                        <v-col
                          cols="12"
                        >
                          <v-file-input
                            @input="formTable.image = $event.target.files[0]"
                            label="Add Image"
                            variant="filled"
                            prepend-icon="mdi-camera"
                          ></v-file-input>
                        </v-col>
                      </v-row>
                    </v-container>
                  </v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                      color="blue-darken-1"
                      variant="text"
                      @click="close"
                    >
                      Cancel
                    </v-btn>
                    <v-btn
                      color="blue-darken-1"
                      variant="text"
                      @click="save"
                    >
                      Save
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                  <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-toolbar>
          </template>
          <template v-slot:item.image="{ item }">
            <div>
              <v-img :src="'/storage/images/brands/'+item.image" :alt="item.name" height="40px"></v-img>
            </div>
          </template>
          <template v-slot:item.actions="{ item }">
            <v-icon
              size="small"
              class="me-2"
              @click="editItem(item)"
              icon="mdi-pencil"
              color="blue-darken-1"
            >
              mdi-pencil
            </v-icon>
            <v-icon
              size="small"
              @click="deleteItem(item)"
              icon="mdi-delete"
              color="red-lighten-2"
            >
              mdi-delete
            </v-icon>
          </template>
          <!-- <template v-slot:no-data>
            <v-btn
              color="primary"
              @click="initialize"
            >
              Reset
            </v-btn>
          </template> -->
        </v-data-table>
      </div>
    </div>
    
  </DashboardLayout>
</template>

<style scoped>
.vuetifyInput >>> input {
  background-color: transparent !important;
  box-shadow: none;
}
</style>