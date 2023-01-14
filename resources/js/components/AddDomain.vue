<template>
    <application>
        <template v-slot:content>
            <Alert v-if="alert" :type="type" :message="message" @alertTimeout="alert = false"/>
            <v-container class="pa-4" fluid>
                <v-card :loading="loading">
                    <v-card-title>
                        Add Domains
                    </v-card-title>
                    <v-card-text>
                        <v-textarea
                            v-model="domains"
                            filled
                            label="Domains"
                            :placeholder="'example.com\nxn--sxqv5g23dyr3a428a.com\n测试假域名.com'"
                            hint="Enter one domain name per line."
                            persistent-hint
                        />
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" width="100%" @click="handleSave">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-container>
        </template>
    </application>
</template>

<script>
  import axios from "axios";
  import Alert from "./Alert";
  export default {
    data () {
        return {
            loading: false,
            domains: '',
            alert: false,
            type: 'success',
            message: '',
        }
    },
      components:{
          Alert
      },
    methods: {
        alertPopUp(alert, type, message){
            this.alert = alert;
            this.type = type;
            this.message = message;
        },
        async handleSave() {
            console.log('handle save!');
            try {
                this.loading = true;
                await axios.post('/api/domains', {
                    domains: this.domains.replace(/\s+/g, ' ').trim().split(' ')
                })
                    .then((response) => {
                        this.alertPopUp(true,'success','Record Saved Successfully.')
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
    }
  }
</script>
