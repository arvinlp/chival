import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import DestinationsList from '../template/views/portal/basic/Destinations.vue';
import DestinationsForm from '../template/views/portal/basic/Destinations-Form.vue';

import VehicleTypeList from '../template/views/portal/basic/Vehicle-Type.vue';
import VehicleTypeForm from '../template/views/portal/basic/Vehicle-Type-Form.vue';

import VehicleBrandList from '../template/views/portal/basic/Vehicle-Brand.vue';
import VehicleBrandForm from '../template/views/portal/basic/Vehicle-Brand-Form.vue';

import InsuranceCompaniesList from '../template/views/portal/basic/Insurance-Companies.vue';
import InsuranceCompanyForm from '../template/views/portal/basic/Insurance-Company-Form.vue';

import TravelTypes from '../template/views/portal/basic/Travel-Type.vue';
import TravelTypeForm from '../template/views/portal/basic/Travel-Type-Form.vue';

import BanksList from '../template/views/portal/basic/Banks.vue';
import BanksForm from '../template/views/portal/basic/Banks-Form.vue';

import CreditsList from '../template/views/portal/credits/Credits.vue';
import CreditForm from '../template/views/portal/credits/Credit-Form.vue';

import ModulesList from '../template/views/portal/modules/Modules.vue';
import ModuleForm from '../template/views/portal/modules/Module-Form.vue';

export default [
  {
    path: 'modules',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-modules',
        components: {header: PageHeader, default: ModulesList},
        props: { header: {title:'لیست ماژول ها'} },
        meta: {
          title: "پرتال مدیریت - ماژول ها"
        },
      },
      {
        path: 'new',
        name: 'portal-module-new',
        components: {header: PageHeader, default: ModuleForm},
        props: { header: {title:'تعریف ماژول جدید'} },
        meta: {
          title: "پرتال مدیریت - ماژول جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-module-edit',
        components: {header: PageHeader, default: ModuleForm},
        props: { header: {title:'ویرایش ماژول'} },
        meta: {
          title: "پرتال مدیریت - ویرایش ماژول"
        },
      },
    ]
  },
  {
    path: 'credits',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-credits',
        components: {header: PageHeader, default: CreditsList},
        props: { header: {title:'لیست اعتبار ها'} },
        meta: {
          title: "پرتال مدیریت - اعتبار ها"
        },
      },
      {
        path: 'new',
        name: 'portal-credit-new',
        components: {header: PageHeader, default: CreditForm},
        props: { header: {title:'تعریف اعتبار جدید'} },
        meta: {
          title: "پرتال مدیریت - اعتبار جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-credit-edit',
        components: {header: PageHeader, default: CreditForm},
        props: { header: {title:'ویرایش اعتبار'} },
        meta: {
          title: "پرتال مدیریت - ویرایش اعتبار"
        },
      },
    ]
  },
  {
    path: 'destinations',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-destinations',
        components: {header: PageHeader, default: DestinationsList},
        props: { header: {title:'لیست مقصد ها'} },
        meta: {
          title: "پرتال مدیریت - مقصد ها"
        },
      },
      {
        path: 'new',
        name: 'portal-destination-new',
        components: {header: PageHeader, default: DestinationsForm},
        props: { header: {title:'افزودن مقصد جدید'} },
        meta: {
          title: "پرتال مدیریت - مقصد جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-destination-edit',
        components: {header: PageHeader, default: DestinationsForm},
        props: { header: {title:'ویرایش مقصد'} },
        meta: {
          title: "پرتال مدیریت - ویرایش مقصد"
        },
      },
    ]
  },
  {
    path: 'vehicle-types',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-vehicle-type',
        components: {header: PageHeader, default: VehicleTypeList},
        props: { header: {title:'انواع وسایل نقیله'} },
        meta: {
          title: "پرتال مدیریت - انواع وسایل نقلیه"
        },
      },
      {
        path: 'new',
        name: 'portal-vehicle-type-new',
        components: {header: PageHeader, default: VehicleTypeForm},
        props: { header: {title:'افزودن نوع وسلیه نقلیه جدید'} },
        meta: {
          title: "پرتال مدیریت - نوع وسلیه نقلیه جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-vehicle-type-edit',
        components: {header: PageHeader, default: VehicleTypeForm},
        props: { header: {title:'ویرایش نوع وسیله نقلیه'} },
        meta: {
          title: "پرتال مدیریت - ویرایش نوع وسیله نقلیه"
        },
      },
    ]
  },
  {
    path: 'vehicle-brand',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-vehicle-brand',
        components: {header: PageHeader, default: VehicleBrandList},
        props: { header: {title:'لیست وسیله نقلیهسازها'} },
        meta: {
          title: "پرتال مدیریت - وسیله نقلیهسازها"
        },
      },
      {
        path: 'new',
        name: 'portal-vehicle-brand-new',
        components: {header: PageHeader, default: VehicleBrandForm},
        props: { header: {title:'افزودن وسیله نقلیهساز جدید'} },
        meta: {
          title: "پرتال مدیریت - وسیله نقلیهساز جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-vehicle-brand-edit',
        components: {header: PageHeader, default: VehicleBrandForm},
        props: { header: {title:'ویرایش وسیله نقلیهساز'} },
        meta: {
          title: "پرتال مدیریت - ویرایش وسیله نقلیهساز"
        },
      },
    ]
  },
  {
    path: 'insurance-companies',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-insurance-companies',
        components: {header: PageHeader, default: InsuranceCompaniesList},
        props: { header: {title:'لیست شرکت های بیمه'} },
        meta: {
          title: "پرتال مدیریت - شرکت های بیمه"
        },
      },
      {
        path: 'new',
        name: 'portal-insurance-companies-new',
        components: {header: PageHeader, default: InsuranceCompanyForm},
        props: { header: {title:'افزودن شرکت بیمه جدید'} },
        meta: {
          title: "پرتال مدیریت - شرکت بیمه جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-insurance-companies-edit',
        components: {header: PageHeader, default: InsuranceCompanyForm},
        props: { header: {title:'ویرایش شرکت بیمه'} },
        meta: {
          title: "پرتال مدیریت - ویرایش شرکت بیمه"
        },
      },
    ]
  },
  {
    path: 'travel-types',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-travel-types',
        components: {header: PageHeader, default: TravelTypes},
        props: { header: {title:'انواع سفرها'} },
        meta: {
          title: "پرتال مدیریت - انواع سفرها"
        },
      },
      {
        path: 'new',
        name: 'portal-travel-types-new',
        components: {header: PageHeader, default: TravelTypeForm},
        props: { header: {title:'افزودن نوع سفر جدید'} },
        meta: {
          title: "پرتال مدیریت - نوع سفر جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-travel-types-edit',
        components: {header: PageHeader, default: TravelTypeForm},
        props: { header: {title:'ویرایش نوع سفر'} },
        meta: {
          title: "پرتال مدیریت - ویرایش نوع سفر"
        },
      }
    ]
  },
  {
    path: 'banks',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-banks',
        components: {header: PageHeader, default: BanksList},
        props: { header: {title:'لیست بانک و حسابهای بانکی ها'} },
        meta: {
          title: "پرتال مدیریت - بانک ها"
        },
      },
      {
        path: 'new',
        name: 'portal-banks-new',
        components: {header: PageHeader, default: BanksForm},
        props: { header: {title:'افزودن بانک جدید'} },
        meta: {
          title: "پرتال مدیریت - بانک جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-banks-edit',
        components: {header: PageHeader, default: BanksForm},
        props: { header: {title:'ویرایش بانک و حساب بانکی'} },
        meta: {
          title: "پرتال مدیریت - ویرایش بانک و حساب بانکی"
        },
      }
    ]
  },
];
