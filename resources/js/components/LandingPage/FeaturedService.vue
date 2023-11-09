<template>
    <section class="our-service light-background editors mar-top"  data-iq-gsap="onStart" data-iq-position-y="70" data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out" data-iq-opacity="0">
        <div class="container">
            <div class="header-title d-flex align-items-center justify-content-between flex-wrap gap-3">
                <h3 class="title">{{__('messages.featured')}} {{__('messages.service')}}</h3>
                <router-link :to="{ name: 'service' }"> <span class="link-btn-box">{{__('messages.see_all')}}</span></router-link>
            </div>
            <div class="row">
                <div class="sidebar-title d-flex align-items-center justify-content-between">
                    <h4></h4>
                    <div @click="resetFilter">
                        <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18.1085 8.94037C18.1085 8.94037 14.9368 4.5 10.1792 4.5C8.07626 4.5 6.05943 5.3354 4.57242 6.82242C3.0854 8.30943 2.25 10.3263 2.25 12.4292C2.25 14.5322 3.0854 16.549 4.57242 18.036C6.05943 19.5231 8.07626 20.3585 10.1792 20.3585C12.9354 20.3585 15.363 18.851 16.7839 16.9429" stroke="#008fb2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.801 5.65222L19.1194 10.1704L14.6035 9.46938" stroke="#008fb2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg> 
                    </div>                           
                </div>
                <div class="form-group">
                    <label for="status" class="form-control-label mb-3">{{__('messages.filter_by_category')}}</label>
                    <multi-select
                            :options="allcategory"
                            :multiple="false"
                            :searchable="false"
                            :close-on-select="false"
                            :show-labels="false"
                            @input="handleFilterChange"
                            placeholder="Select one"
                            id="status" 
                            v-model="filterData.category_id"
                            label="name" 
                            track-by="id" 
                    ></multi-select>
                </div>
                <div class="form-group">
                    <label for="subCategories" class="form-control-label mb-3">{{__('messages.filter_by_sub_category')}}</label>
                    <multi-select
                        deselect-label=""
                        select-label=""
                        @input="handleFilterChange"
                        tag-placeholder="subCategories" 
                        id="subCategories" 
                        v-model="filterData.subcategory_id"
                        label="name" 
                        track-by="id" 
                        :options="allSubCategories"
                    ></multi-select>
                </div>
                <div class="form-group">
                    <label for="providers" class="form-control-label mb-3">{{__('messages.filter_by_providers')}}</label>
                    <multi-select
                            deselect-label=""
                            select-label=""
                            @input="handleFilterChange"
                            tag-placeholder="providers" id="providers" 
                            v-model="filterData.provider_id"
                            label="display_name" track-by="id" :options="allprovider"
                    ></multi-select>
                </div>
                <div class="form-group">
                    <label for="countries" class="form-control-label mb-3">{{__('messages.filter_by_country')}}</label>
                    <multi-select
                    deselect-label=""
                    select-label=""
                    @input="handleFilterChange"
                    tag-placeholder="countries" 
                    id="countries" 
                    v-model="filterData.country_id"
                    label="name" 
                    track-by="id" 
                    :options="allcountry"
                    ></multi-select>
                </div>
                <div class="form-group">
                    <label for="cities" class="form-control-label mb-3">{{__('messages.filter_by_city')}}</label>
                    <multi-select
                    deselect-label=""
                    select-label=""
                    @input="handleFilterChange"
                    tag-placeholder="cities" 
                    id="cities" 
                    v-model="filterData.city_id"
                    label="name" 
                    track-by="id" 
                    :options="allcities"
                    ></multi-select>
                </div>
                <div class="form-group">
                <label for="search" class="form-control-label mb-3">{{__('messages.filter_by_text')}}</label>
                    <input class="form-control" type="text" v-model="filterData.search" @input="handleFilterChange" id="search" placeholder="Enter text">
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 list-inline">
                <div v-for="(data, index) in featuredservice" :key="index"  class="col">
                    <service-list v-if="index < 4"
                        :serviceId="data.id"
                        :imageUrl="data.attchments[0] ? data.attchments[0] : baseUrl+'/images/default.png'"
                        :is_favourite="data.is_favourite"
                        :servicePrice="data.price_format"
                        :serviceName="data.name"
                        :serviceRating="data.total_rating"
                        :serviceDescription="data.description"
                        :serviceProviderImg="data.provider_image"
                        :serviceProvider="data.provider_name"
                        :cityName="data.city_name"
                        :isVarified="data.is_varified"
                        :countryName="data.country_name"
                        @service-list="getServiceList"
                        :serviceType="data.type"
                        :categoryName="data.category_name"
                        :subcategoryName="data.subcategory_name"
                    />
                </div>
            </div>
        </div>
    </section>
</template>
<script>
import { mapGetters } from "vuex";
import {get} from '../../request'

export default {
    name:'FeaturedService',
    data(){
      return {
          loading: true,
          baseUrl:window.baseUrl,
          filterData: {
                sub_category_id: {},
                sort_by: null,
                search: ''

            },
        featuredservice:[],
        allcountry: [],
        allcities: [],
        allSubCategories: [],
        sortingOptions: [
            { id: 'automatic', name: 'Automatic' },
            { id: 'lowest_price', name: 'Lowest Price' },
            { id: 'highest_price', name: 'Highest Price' },
            { id: 'latest_service', name: 'Latest Service' },
        ],
      }
    },
    computed: {
        ...mapGetters(['featuredservice','service','allcategory','allprovider']),
    },
    mounted(){
        console.log('Component mounted');
        this.filterData = this.defaultFilterData();
        this.getServiceList();
        this.loading = true;
    },
    created() {
        console.log('Component created');
        this.getAllCountries();
        this.getAllCities();
        this.getAllSubCategories();
    },
    methods:{
        defaultFilterData: function () {
            return {
                category_id: {},
                provider_id:{},
                is_price_min: this.minVal,
                is_price_max: this.maxVal,
                is_rating: [],
                latitude:'',
                longitude:'',
                country_id: {},
                city_id: {},
                subcategory_id: {},
                sort_by: {},
            }
        }, 
        getAllCountries() {
                get("country-list") 
                    .then((response) => {
                    if (response.status === 200) {
                        console.log('response from api',response);
                        this.allcountry = response.data; 
                    } else {
                        this.allcountry = []; 
                    }
                    })
                    .catch((error) => {
                    console.error("Error fetching country list:", error);
                    });
            },
            getAllCities() {
                if (this.filterData.country_id && this.filterData.country_id.id) {
                get(`city-list?country_id=${this.filterData.country_id.id}`)
                    .then((response) => {
                        if (response.status === 200) {
                            console.log(response.data)
                            this.allcities = response.data;
                        } else {
                            this.allcities = [];
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching city list:", error);
                    });
                }
    
            },
            getServiceList(filterData=''){
                this.loading = true;
                var params= {
                    per_page: "all",
                    is_featured:1,
                    sort_by: this.filterData.sort_by,
                    search: this.filterData.search 
                }
                var get_location_lat = localStorage.getItem('loction_current_lat')
                var get_location_long = localStorage.getItem('loction_current_long')
                var  latitude = ''
                var  longitude = ''
                if(get_location_lat  !='' && get_location_long != '' ){
                    var  latitude = get_location_lat
                    var  longitude = get_location_long
                    var params= {
                        per_page: "all",
                        is_featured:1,
                        latitude:latitude,
                        longitude:longitude,
                    }
                }
                
                if(filterData != '' ){
                    var params ={
                        is_featured:1,
                        category_id:filterData.category_id.id,
                        provider_id:filterData.provider_id.id,
                        country_id: filterData.country_id ? filterData.country_id.id : '',
                        city_id: filterData.city_id ? filterData.city_id.id : '',
                        subcategory_id: filterData.subcategory_id ? filterData.subcategory_id.id : '',
                        sort_by: filterData.sort_by ? filterData.sort_by.id : '',
                        search: this.filterData.search ? this.filterData.search : '',
                        latitude:latitude,
                        longitude:longitude,
                        per_page: 'all'
                    }
                }
                if(this.$store.state.user){
                     var params ={
                        is_featured:1,
                        customer_id: this.$store.state.user.id,
                        latitude:latitude,
                        longitude:longitude,
                        category_id:this.filterData.category_id != {} ? this.filterData.category_id.id :'',
                        provider_id:this.filterData.provider_id != {} ? this.filterData.provider_id.id : '',
                        per_page: 'all'
                     }
                }
                get("service-list",{
                    params: params
                })
                .then((response) => {
                    // console.log(response);
                    if(response.status === 200){
                        this.featuredservice = response.data.data;
                    }else{
                        this.featuredservice = [];
                    }
                    this.loading = false; 
                });
            },
             
            handleFilterChange(){
                this.getAllCities();
                this.getAllSubCategories();
                let filterData = Object.assign({}, this.filterData);
                this.getServiceList(filterData);
            },
            getAllSubCategories() {
                // console.log(this.filterData.category_id.id);
                if (this.filterData.category_id && this.filterData.category_id.id) {
                get(`subcategory-list?category_id=${this.filterData.category_id.id}`)
                    .then((response) => {
                        if (response.status === 200) {
                            this.allSubCategories = response.data;
                            this.allSubCategories = this.allSubCategories.data;
                            // console.log(this.allSubCategories)
                    } else {
                        this.allSubCategories = [];
                    }
                    })
                    .catch((error) => {
                    console.error("Error fetching sub-category list:", error);
                    });
                } else {
                this.allSubCategories = [];
                }
            },
            resetFilter(){
               this.filterData.category_id = ''
               this.filterData.provider_id = ''
               this.filterData.country_id = ''
               this.filterData.city_id = ''
               this.filterData.subcategory_id = ''
               this.filterData.search = ''
               this.getServiceList(this.featuredservice)
            }

    }
}
</script>