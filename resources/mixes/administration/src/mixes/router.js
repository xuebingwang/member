import Dashboard from '../pages/Dashboard.vue';
import Group from '../pages/Group.vue';
import GroupCreate from '../pages/GroupCreate.vue';
import GroupEdit from '../pages/GroupEdit.vue';
import Layout from '../layouts/Layout.vue';
import Security from '../pages/Security.vue';
import User from '../pages/User.vue';
import UserCreate from '../pages/UserCreate.vue';

export default function (injection) {
    injection.useModuleRoute([
        {
            children: [
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Dashboard,
                    path: '/',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Group,
                    path: 'group',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: GroupCreate,
                    path: 'group/create',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: GroupEdit,
                    path: 'group/:id/edit',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: Security,
                    path: 'security',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: User,
                    path: 'user',
                },
                {
                    beforeEnter: injection.middleware.requireAuth,
                    component: UserCreate,
                    path: 'user/create',
                },
            ],
            component: Layout,
            path: '/member',
        },
    ]);
}
