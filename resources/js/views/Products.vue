<template>

    <div>
        <v-dialog v-model="dialogInfo" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">Mensaje</v-card-title>
                <v-card-text>{{ messageInfo }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="text-capitalize" color="primary" rounded @click.native="dialogInfo = false">OK</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog persistent v-model="dialogCreate" max-width="600">
            <v-card>
                <v-card-title class="headline">{{editing?'Editar usuario':'Crear usuario'}}</v-card-title>
                <div>
                    <v-form v-model="valid" ref="formData" lazy-validation>
                        <v-row class="px-5">
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    required
                                    v-model="currentData.correo"
                                    label="Correo"
                                    :disabled="editing"
                                    name="Correo"
                                    :rules="[rules.required, rules.email]"
                                    type="text"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    required
                                    :rules="nameRules"
                                    v-model="currentData.nombre"
                                    label="Nombre"
                                    type="text"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="px-5">
                            <v-col cols="12" sm="6" md="6">
                                <v-autocomplete
                                    label="Selecciona El tipo"
                                    v-model="currentData.tipo"
                                    :items="tipos"
                                    :rules="nameRules"
                                    no-data-text="Escribe para buscar "
                                    item-text="nombre"
                                >
                                    <template v-slot:no-data>
                                        <span>No se encontraron estudiantes</span>
                                    </template>
                                </v-autocomplete>
                            </v-col>
                        </v-row>
                    </v-form>
                </div>
                <v-card-actions>
                    <div class="flex-grow-1"></div>

                    <v-btn class="text-capitalize" color="primary" outlined rounded @click="cancelCreate()">
                        <v-icon right>cancel</v-icon>Cancelar
                    </v-btn>
                    <v-btn class="text-capitalize" color="primary" rounded @click="create()">
                        <v-icon right>save</v-icon>
                        {{editing?'Guardar':'Crear'}}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- DIALOGO ELIMINAR -->
        <v-dialog v-model="dialogDelete" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">¿Desea eliminar el dato seleccionado?</v-card-title>
                <v-card-text>Al eliminar no se podrá recuperar posteriormente.</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn class="text-capitalize" @click.native="dialogDelete = false" rounded>No</v-btn>
                    <v-btn class="text-capitalize" color="primary" rounded @click.native="confirmDelete()">Sí</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <!-- LISTA -->
        <v-layout row justify-center wrap>
            <v-flex xs12>
                <v-card>
                    <v-card-title>
                        Creación de Usuarios
                        <v-spacer></v-spacer>
                        <v-btn class="text-capitalize mx-2" color="primary" outlined rounded @click.native="agregarUsuarios()">Importar usuarios</v-btn>
                        <v-btn class="text-capitalize" color="primary" rounded @click.stop="dialogCreateOpen()">Crear Usuario</v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-data-table :headers="headers" :items="items">
                            <template v-slot:item.action="{ item }">
                                <v-icon small class="pr-2" @click="editItem(item)">edit</v-icon>
                                <v-icon small @click="deleteItem(item)">delete</v-icon>
                            </template>
                            <template slot="no-data">No se encontraron grupos</template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </div>

</template>

<script>

export default {
  data () {
    return {
      nameRules: [v => !!v || 'Campo requerido'],
      valid: true,
      path: 'usuarios/',
      dialogView: false,
      messageInfo: '',
      dialogInfo: false,
      config: {},
      dialogDelete: false,
      tipos: [{ nombre: 'PROFESOR' }, { nombre: 'ESTUDIANTE' }, { nombre: 'ADMINISTRADOR' }, { nombre: 'JEFE' }],
      headers: [
        { text: 'Correo', value: 'correo' },
        { text: 'Nombre', value: 'nombre' },
        { text: 'Tipo', value: 'tipo' },
        { text: 'Acciones', value: 'action', sortable: false }
      ],
      items: [],
      currentData: {},
      loading: false,
      toDelete: undefined,
      toPreview: undefined,
      dialogCreate: false,
      dialogPost: false,
      editing: true,
      fileToImport: undefined,
      rules: {
        email: value => {
          const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          return pattern.test(value) || 'Correo Inválido'
        }
      }
    }
  },
  beforeMount () {
    console.log(process.env)
    this.loadData()
  },
  methods: {
    cancelArchivo () {
      this.dialogPost = false
      this.toUpload = {}
    },
    dialogCreateOpen () {
      this.currentData = {}
      this.editing = false
      this.dialogCreate = true
    },
    editItem (item) {
      this.currentData = Object.assign({}, item)
      this.dialogCreate = true
      this.editing = true
    },
    saveData (data) {
      let url = this.path
      var options = {
        headers: { token: '' }
      }
      this.loading = true
      if (this.editing) {
        url += data.correo
        this.$axios
          .put(url, data, options)
          .then(async res => {
            const data = res
            if (data.status === 200) {
              this.dialogCreate = false
              this.typeMessage = 'info'
              this.messageInfo = 'Se guardo correctamente'
              this.currentData = {}
              this.dialogInfo = true
              this.loadData()
            }
          })
          .catch(() => {
            this.typeMessage = 'error'
            this.messageInfo = 'Hubo un error al guardar'
          })
          .finally(() => {
            this.loading = false
          })
        this.loading = false
      } else {
        data.contrasena = data.correo
        this.$axios
          .post(url, data, options)
          .then(async res => {
            const data = res
            if (data.status === 200) {
              this.dialogCreate = false
              this.typeMessage = 'info'
              this.messageInfo = 'Se guardo correctamente'
              this.currentData = {}
              this.dialogInfo = true
              this.editing = false
              this.loadData()
            }
          })
          .catch(() => {
            this.typeMessage = 'error'
            this.messageInfo = 'Hubo un error al guardar'
          })
          .finally(() => {
            this.loading = false
          })
        this.loading = false
      }
    },
    create () {
      if (this.$refs.formData.validate()) {
        this.saveData(this.currentData)
      } else {
        this.messageInfo = 'Error por favor revisa los campos'
        this.dialogInfo = true
        this.typeMessage = 'error'
      }
    },
    cancelCreate () {
      this.dialogCreate = false
    },
    deleteItem (item) {
      this.dialogDelete = true
      this.toDelete = item
    },
    confirmDelete () {
      const url = this.path + this.toDelete.correo

      var options = {
        headers: { token: '' }
      }
      this.loading = true
      this.$axios
        .delete(url, options)
        .then(async res => {
          const data = res
          if (data.status === 200) {
            this.dialogDelete = false
            this.dialogInfo = true
            this.messageInfo = 'Eliminado Correctamente'
            this.loadData()
          }
        })
        .catch(() => {
          this.dialogDelete = false
          this.dialogInfo = true
          this.messageInfo = 'Revisa que el usuario no este en algún grupo o equipo'
        })
        .finally(() => {
          this.loading = false
        })
      this.loading = false
    },
    async loadData () {
      const data = await this.getAllData()
      if (data.status === 200) {
        this.items = data.data
      }
    },
    async getAllData () {
      const url = this.path
      var options = {
        headers: { token: 'token' }
      }
      this.loading = true
      const response = await this.$axios.get(url, options)
      this.loading = false
      return response
    }
  }
}
</script>
