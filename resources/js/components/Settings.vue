<template>
    <application>
        <template v-slot:content>
            <Alert v-if="alert" :type="type" :message="message" @alertTimeout="alert = false"/>
            <v-container class="pa-4" fluid>
                <v-card>
                    <v-card-title>
                        Settings
                    </v-card-title>
                    <v-card-text>
                        <v-select
                            :items="items"
                            filled
                            label="Dark Mode"
                            hint="Darkens the application's user interface."
                            persistent-hint
                            @change="handleChange"
                        />
                    </v-card-text>
                </v-card>
            </v-container>
        </template>
    </application>
</template>

<script>
import Alert from "./Alert";
  export default {
    data: () => ({
        items: [
            { text: 'Enabled', value: true },
            { text: 'Disabled', value: false }
        ],
        alert: false,
        type: 'success',
        message: '',
    }),
      components:{
          Alert
      },
    methods: {
        alertPopUp(alert, type, message){
            this.alert = alert;
            this.type = type;
            this.message = message;
        },
        handleChange(value) {
            this.$vuetify.theme.dark = value
            this.$store.commit('settings/changeMode',value);
            this.alertPopUp(true,'success','Theme Changed Successfully.')
            console.log('handle change', value);
        }
    }
  }
</script>
