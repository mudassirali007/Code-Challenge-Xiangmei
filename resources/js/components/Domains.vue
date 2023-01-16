<template>
    <application>
        <template v-slot:content>
            <Alert v-if="alert" :type="type" :message="message" @alertTimeout="alert = false"/>
            <v-container class="pa-4" fluid>
                <v-card>
                    <v-card-title>
                        Domains
                        <div class="flex-grow-1" />
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                            @input="handleSearch"
                        />
                    </v-card-title>
                    <v-data-table
                        :headers="headers"
                        :items="filteredDomains"
                        :loading="loading"
                        :page.sync="page"
                        :items-per-page="itemsPerPage"
                        hide-default-footer
                        disable-sort
                    >
                        <template v-slot:body="{ items }">
                            <tbody>
                                <tr v-for="item in items" :key="item.id">
                                    <td>
                                        {{ item.domain_name }}
                                    </td>
                                    <td>{{ new Date(item.updated_at).toLocaleString() }}</td>
                                    <td>{{ item.is_idn ? 'Yes' : 'No' }}</td>
                                    <td>{{ item.is_imprinted ? 'Yes' : 'No' }}</td>
                                    <td>
                                        <v-btn icon @click="handleImprint(item.id,item.is_imprinted ? 0 : 1)">
                                            <v-icon>mdi-fingerprint</v-icon>
                                        </v-btn>
                                        <v-btn icon @click="handleDelete(item.id)">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-data-table>
                    <v-row class="text-center px-4 align-center" wrap>
                        <v-col class="text-truncate" cols="12" md="2">
                            Total {{ totalRecords }} records
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-pagination
                                v-model="page"
                                :length="pageCount">
                            </v-pagination>
                        </v-col>
                    </v-row>
                </v-card>
                <v-btn
                    fab
                    color="primary"
                    bottom
                    right
                    absolute
                    to="/domains/add"
                    >
                    <v-icon>mdi-plus</v-icon>
                </v-btn>
            </v-container>
        </template>
    </application>
</template>

<script>
  import axios from 'axios';
  import Alert from "./Alert";

  export default {
    data () {
        return {
            page: 1,
            itemsPerPage: 10,
            loading: false,
            search: '',
            headers: [
                { text: 'Domain Name', value: 'domain_name', },
                { text: 'Updated At', value: 'updated_at' },
                { text: 'Internationalized', value: 'is_idn' },
                { text: 'Imprinted', value: 'is_imprinted' },
                { text: 'Actions' }
            ],
            domains: [],
            alert: false,
            type: 'success',
            message: '',
        }
    },
      computed: {
          filteredDomains() {
              let tempDomains = this.domains
              // Process search input
              if (this.search != '' && this.search) {
                  tempDomains = tempDomains.filter((item) => {
                      return item.domain_name
                          .includes(this.search)
                  })
              }
              return tempDomains
          },
          totalRecords() {
              return this.filteredDomains.length
          },
          pageCount() {
              return Math.ceil(this.totalRecords / this.itemsPerPage)
          },
      },
      components:{
          Alert
      },
    mounted() {
        this.fetchDomains();
    },
    methods: {
        alertPopUp(alert, type, message){
            this.alert = alert;
            this.type = type;
            this.message = message;
        },
        async fetchDomains() {
            try {
                this.loading = true;
                const domains = await axios.get('/api/domains');
                this.domains = domains.data;
                this.alertPopUp(true,'success','Listing Successfully.')

            }
            catch (e) {
                this.alertPopUp(true,'error',e)
                console.log(e);
            }
            finally {
                this.loading = false;
            }
        },
        handleSearch(value) {
            console.log('handle the search!', value);
        },
        async handleDelete(id) {
            console.log('handle the delete!');
            try {
                this.loading = true;
                await axios.delete(`/api/domains/${id}`)
                    .then((response) => {
                        this.domains.splice(this.domains.map(item => item.id).indexOf(id), 1)
                        this.alertPopUp(true,'success','Record Deleted Successfully.')
                        console.log(response.data)
                    })
                    .catch((error) => {
                        this.alertPopUp(true,'error',error)
                        console.error(error)
                    });
            }
            catch (e) {
                this.alertPopUp(true,'error',e)
                console.error(e);
            }
            finally {
                this.loading = false;
            }
        },
        async handleImprint(id,is_imprinted) {
            console.log('handle the imprint!');
            try {
                this.loading = true;
                await axios.put(`/api/domains/${id}`, {
                    is_imprinted: is_imprinted
                })
                    .then((response) => {
                        this.domains = this.domains.map(item => {
                            if (item.id === id) return {...item, is_imprinted};
                            return item;
                        })
                        this.alertPopUp(true,'success','Record Imprinted Successfully.')

                        console.log(response.data)
                    })
                    .catch((error) => {
                        this.alertPopUp(true,'error',error)
                        console.error(error)
                    });
            }
            catch (e) {
                this.alertPopUp(true,'error',e)
                console.error(e);
            }
            finally {
                this.loading = false;
            }
        }
    }
  }
</script>
