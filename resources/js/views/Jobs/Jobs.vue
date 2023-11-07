<template>
    <div>
         <breadcrumb :sectionName="this.$route.meta.label" :homeName="this.$route.meta.homeName" />
         <section class="our-service our-service-lists mar-top mar-bot editors"  data-iq-gsap="onStart" data-iq-position-y="70" data-iq-rotate="0" data-iq-trigger="scroll" data-iq-ease="power.out" data-iq-opacity="0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 category-sidebar">
                    <div class="sidebar-title d-flex align-items-center justify-content-between">
                        <h4>{{__('messages.filter')}}</h4>
                        <div @click="resetFilter">
                            <svg  width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.1085 8.94037C18.1085 8.94037 14.9368 4.5 10.1792 4.5C8.07626 4.5 6.05943 5.3354 4.57242 6.82242C3.0854 8.30943 2.25 10.3263 2.25 12.4292C2.25 14.5322 3.0854 16.549 4.57242 18.036C6.05943 19.5231 8.07626 20.3585 10.1792 20.3585C12.9354 20.3585 15.363 18.851 16.7839 16.9429" stroke="#008fb2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M19.801 5.65222L19.1194 10.1704L14.6035 9.46938" stroke="#008fb2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg> 
                        </div>                           
                    </div>
               
                    <div class="row">
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
                    </div>

                    <div class="row">
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
                    </div>

                    <div class="row">
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
                    </div>

                    <div class="row">
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
                    </div>
                    
                    <div class="row">
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
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <label for="sort_by" class="form-control-label mb-3">{{__('messages.sort_by')}}</label>
                            <multi-select
                            deselect-label=""
                            select-label=""
                            @input="handleFilterChange"
                            tag-placeholder="Sort By"
                            id="sort_by"
                            v-model="filterData.sort_by"
                            label="name"
                            track-by="id"
                            :options="sortingOptions"
                            ></multi-select>
                        </div>
                    </div>
               
                </div>
                    <div class="col-lg-12">
                        <div v-if="loading" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 list-inline service-card-box">
                          <img :src="baseUrl+'/images/frontend/not_found.gif'"  class="datanotfound" />
                        </div>
                        <div v-else-if="jobList.length > 0" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 list-inline service-card-box">
                            <div v-for="(data, index) in jobList" :key="index" class="col">
                                <!-- <router-link :to="{name: 'job-detail',params: { job_id: data.id,job_name:data.title }}"> -->
                                <div class="card">
                                        <div class="iq-image position-relative">
                                            <div class="img">
                                                <!-- <img :src="data.attchments[0] ? data.attchments[0] : baseUrl+'/images/default.png'" alt="image" class="img-fluid w-100 "/> -->
                                            </div>
                                            <!-- <span class="badge badge-2 bg-primary"><i class="fa fa-eye" aria-hidden="true"></i> {{ data.total_views }}</span> -->
                                        </div>
                                        <div class="card-body">
                                            <div class="content-title mb-3">
                                                <h5 class="service-title" data-bs-toggle="tooltip" data-bs-placement="top" :title="data.title">{{ data.title }}</h5>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
    
                        <div v-else-if="jobList.length == 0" class="text-center">
                            <p>{{__('messages.data_not_found')}}</p>
                        </div>
                        <div v-else class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-3 list-inline service-card-box">
    
                          <img :src="baseUrl+'/images/frontend/not_found.gif'"  class="datanotfound" />
                        </div>
                    </div>
                </div>
            </div> 
         </section>
    </div>
</template> 

<script>
import { mapGetters } from "vuex";
import noUiSlider from 'nouislider'
import { get } from '../../request'

export default {
    name: 'Jobs',
    data() {
        return {
            loading: true,
            jobList: [], // Initialize jobList as an empty array
            baseUrl: window.baseUrl,
            filterData: {
                sub_category_id: {},
                sort_by: null,
            },
            componentKey: 0,
            serviceList:[],
            baseUrl:window.baseUrl,
            maxVal:0,
	        minVal:0,
            ratingData:[
                {
                    id:1,
                    title: '1.0',
                    value: 1
                },
                {
                    id:2,
                    title: '2.0',
                    value: 2
                },
                {
                    id:3,
                    title: '3.0',
                    value: 3
                },
                {
                    id:4,
                    title: '4.0',
                    value: 4
                },
                {
                    id:5,
                    title: '5.0',
                    value: 5
                },
            ],
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
        ...mapGetters(['allcategory','allprovider','currencySymobl'])
    },
    mounted() {
        console.log('Component mounted');
        this.filterData = this.defaultFilterData();
        this.getServiceList();
        this.loading = true;
    },
    created() {
        this.getAllCountries();
        this.getAllCities();
        this.getAllSubCategories();
    },
    methods: {
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
                        // console.log(response.data)
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
                sort_by: this.filterData.sort_by,
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
                    latitude:latitude,
                    longitude:longitude,
                }
            }
            
            if(filterData != '' ){
                var params ={
                    // category_id:filterData.category_id.id,
                    provider_id:filterData.provider_id.id,
                    country_id: filterData.country_id ? filterData.country_id.id : '',
                    city_id: filterData.city_id ? filterData.city_id.id : '',
                    // subcategory_id: filterData.subcategory_id ? filterData.subcategory_id.id : '',
                    sort_by: filterData.sort_by ? filterData.sort_by.id : '',
                    latitude:latitude,
                    longitude:longitude,
                    per_page: 'all'
                }
            }
            get("get-job-list",{
                params: params
            })
            .then((response) => {
                console.log("response from api", response);
                if(response.status === 200){
                    this.jobList = response.data.data;
                }else{
                    this.jobList = [];
                }
                this.loading = false; 
            });
        },
        handleFilterChange(){
            this.getAllCities();
            this.getAllSubCategories();
            let filterData = Object.assign({}, this.filterData);
            this.getServiceList(filterData);
            console.log(filterData);
        },
        getAllSubCategories() {
            // console.log(this.filterData.category_id.id);
            if (this.filterData.category_id && this.filterData.category_id.id) {
            get(`subcategory-list?category_id=${this.filterData.category_id.id}`)
                .then((response) => {
                    if (response.status === 200) {
                        this.allSubCategories = response.data;
                        this.allSubCategories = this.allSubCategories.data;
                        console.log(this.allSubCategories)
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
           this.filterData.provider_id = ''
           this.filterData.country_id = ''
           this.filterData.city_id = ''
           this.filterData.sort_by = ''
           this.getServiceList(this.filterData)
        }

    }
}
</script>
