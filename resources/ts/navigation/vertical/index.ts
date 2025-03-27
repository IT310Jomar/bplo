import type { VerticalNavItems } from '@/@layouts/types'

export default [

  //ADMIN

  {
    title: 'Dashboard',
    to: { name: 'index' },
    icon: { icon: 'tabler-smart-home' },
    subject: 'SystemAndAdmin',
  },
  {
    title: 'Regular Officer',
    to: { name: 'admin-regular-list' },
    icon: { icon: 'tabler:user-shield' },
    subject: 'SystemAndAdmin',
  },

  {
    title: 'Client List',
    to: { name: 'admin-clientlist' },
    icon: { icon: 'material-symbols:groups-sharp' },
    subject: 'SystemAndAdmin',
  },

  {
    title: 'Request Permit',
    to: { name: 'admin-request-permit' },
    icon: { icon: 'tabler-file' },
    subject: 'SystemAndAdmin',
  },
  {
    title: 'Generate Permit',
    to: { name: 'admin-generated-permit' },
    icon: { icon: 'file-icons:nsri-alt' },
    subject: 'SystemAndAdmin',
  },

  // {
  //   title: 'Permit Status',
  //   to: { name: 'admin-permitstatus' },
  //   icon: { icon: 'fa6-solid:address-book' },
  //   subject: 'SystemAndAdmin',
  // },

  // {
  //   title: 'Notification',
  //   to: { name: 'admin-notification' },
  //   icon: { icon: 'material-symbols:circle-notifications-outline' },
  //   subject: 'SystemAndAdmin',
  // },  

  {
    title: 'History',
    to: { name: 'admin-generated_history' },
    icon: { icon: 'material-symbols:circle-notifications-outline' },
    subject: 'SystemAndAdmin',
  }, 


  //BUCO
{
  title: 'Buco Dashboard',
  to: { name: 'index' },
  icon: { icon: 'material-symbols:circle-notifications-outline' },
  subject: 'SystemAndBuco',
},

{
  title: 'Request Approval',
  to: { name: 'buco-approval-request' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBuco',

},

{
  title: 'List Of Approved',
  to: { name: 'buco-list-approve' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBuco',

},

{
  title: 'List Of Rejected',
  to: { name: 'buco-reject-list' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBuco',

},



{
  title: 'CleanRo Dashboard',
  to: { name: 'index' },
  icon: { icon: 'tabler-smart-home' },
  subject: 'SystemAndCleanRo',

},

{
  title: 'Request Approval',
  to: { name: 'cleanro-pendingapproval'},
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndCleanRo',

},

{
  title: 'List Of Approved',
  to: { name: 'cleanro-list-approve' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndCleanRo',

},

{
  title: 'List Of Rejected',
  to: { name: 'cleanro-list-reject' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndCleanRo',

},

//BFP

{
  title: 'BFP Dashboard',
  to: { name: 'index' },
  icon: { icon: 'tabler-smart-home' },
  subject: 'SystemAndBFP',

},

{
  title: 'Request Approval',
  to: { name: 'bfp-approval-Request' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBFP',

},

{
  title: 'List Of Approved',
  to: { name: 'bfp-list-approve' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBFP',

},


{
  title: 'List Of Rejected',
  to: { name: 'bfp-reject-list' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndBFP',

},

//HEALTH

{
  title: 'Health Dashboard',
  to: { name: 'index' },
  icon: { icon: 'tabler-smart-home' },
  subject: 'SystemAndHealth',
},
{
  title: 'Request Approval',
  to: { name: 'health-pendingapproval' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndHealth',
},
{
  title: 'List of Approved',
  to: { name: 'health-list-approve' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndHealth',
},
{
  title: 'List of Rejected',
  to: { name: 'health-list-reject' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndHealth',
},
{
  title: 'History',
  to: { name: 'health-history' },
  icon: { icon: 'material-symbols:groups-sharp' },
  subject: 'SystemAndHealth',
},
 
] as VerticalNavItems
