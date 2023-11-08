<template>
    <div class="card">
        <div class="iq-image position-relative">
            <router-link :to="{name: 'service-detail',params: { service_id: serviceId }}">
                <div class="img">
                    <img :src="imageUrl" alt="image" class="img-fluid w-100 "/>
                </div>
            </router-link>
            <favorite :servicedata="serviceId" :favorited="is_favourite" @emit-list="serviceListEmit"/>
            <span class="badge badge-2 bg-primary">{{ servicePrice }}</span>
            <span class="badge badge-2 bg-primary"><small v-if="!servicePrice">Free</small> </span>
            <span class="badge badge-1 rounded-pill bg-white text-primary" data-bs-toggle="tooltip" data-bs-placement="top" :title="subcategoryName == null ? categoryName : subcategoryName" v-if="scrolltitle(subcategoryName)"><marquee scrollamount="1">{{ subcategoryName == null ? categoryName : subcategoryName }}</marquee></span>
            <span class="badge badge-1 rounded-pill bg-white text-primary" data-bs-toggle="tooltip" data-bs-placement="top" :title="subcategoryName == null ? categoryName : subcategoryName" v-else>{{ subcategoryName == null ? categoryName : subcategoryName }}</span>
        </div>
        <div class="card-body">
            <div class="ratting-box">
                <span class="badge-position">
                    <rating :readonly = true :showrating ="false" :ratingvalue="serviceRating" />
                </span>
            </div>
            <div class="content-title mb-3">
                <router-link :to="{name: 'service-detail',params: { service_id: serviceId }}">
                    <h5 class="service-title" data-bs-toggle="tooltip" data-bs-placement="top" :title="serviceName">{{ serviceName }}</h5>
                </router-link>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="user-info d-flex align-items-center">
                    <img :src="serviceProviderImg" alt="image" class="img-fluid avatar avatar-35 avatar-rounded"/>
                    <span class="ms-2">{{ serviceProvider }}</span>
                    <!-- <span class="ms-2">planImg: {{ isVarifiedImg }}</span> -->
                    <!-- <div class="ms-2" v-if="isVarifiedImg == 1">
                        <img :src="getImageUrl()" alt="Image" class="img-fluid avatar avatar-35 avatar-rounded" />
                    </div>  -->
                    <!-- <div class="ms-2">
                        <img :src="getPlanImageUrl(planImg)" alt="Image" class="img-fluid avatar avatar-35 avatar-rounded" />
                    </div>                 -->
                </div>
                <div class="location-info">
                    <span class="ms-2">{{ displayLocation }}</span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Favorite from './Favorite.vue'
export default {
    data() {
        return {
            baseUrl: process.env.BASE_URL
        }
    },

  components: { Favorite },
    name:'ServiceList',
    props:{
        serviceId: { type: Number },
        imageUrl: { type: String },
        is_favourite: { type: Number },
        servicePrice: { type: String },
        serviceName: { type: String },
        serviceRating: { type: Number },
        serviceDescription: { type: String },
        serviceProviderImg: { type: String },
        isVarifiedImg: { type: String },
        planImg: { type: String },
        countryName: { type: String },
        cityName: { type: String },
        serviceProvider: { type: String },
        serviceType:{type:String},
        categoryName:{type:String},
        subcategoryName:{type:String},
    },
    computed: {
        displayLocation() {
            if (this.cityName && this.countryName) {
                return this.cityName + ' - ' + this.countryName;
            }
            return '';
        }
    },
    methods:{
        getImageUrl() {
            return baseUrl+"/images/varification.png";
        },
        getPlanImageUrl(planImg) {
            return baseUrl+"/images/plans/"+planImg;
        },
        scrolltitle(title){

          if(title !=null){

            let titlecount=title.length 
            if(titlecount>7){
                return true
            }
            else{
                return false
            }
          }else{

            return false
          }
            
           
        },
        serviceListEmit(){
            this.$emit('service-list')
        }
    }
}
</script>
