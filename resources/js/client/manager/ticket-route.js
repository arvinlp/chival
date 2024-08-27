/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-02-15 09:36:02
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import TicketList from '../../template/views/client/ticket-selling/Ticket-List';
import SellingItem from '../../template/views/client/ticket-selling/Sell-Item';
import TicketListAddToList from '../../template/views/client/ticket-selling/Ticket-List-Add-To-List';

export default [
  {
    path: 'ticket',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-ticket',
        components: {header: PageHeader, default: TicketList},
        props: { header: {title:'فروش بیلط'} },
        meta: {
          title: "پرتال شرکت - فروش بلیط"
        },
      },
      {
        path: 'list',
        name: 'client-ticket-add',
        components: {header: PageHeader, default: TicketListAddToList},
        props: { header: {title:'فروش بیلط'} },
        meta: {
          title: "پرتال شرکت - فروش بلیط"
        },
      },
      {
        path: ':id',
        name: 'client-ticket-selling',
        components: {header: PageHeader, default: SellingItem},
        props: { header: {title:'فروش بیلط و مشاهده مسافرین'} },
        meta: {
          title: "پرتال شرکت - مشاهده مسافرین و فروش بیلط برای وسیله نقلیه"
        },
      },
      {
        path: 'cancel/:id',
        name: 'client-ticket-cancel',
        components: {header: PageHeader, default: TicketList},
        props: { header: {title:'لغو بیلط فروخته شده'} },
        meta: {
          title: "پرتال شرکت - لغو بلیط فروخته شده"
        },
      },
    ]
  },
];
