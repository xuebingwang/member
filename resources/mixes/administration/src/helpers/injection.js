import {
    mixinNavigation,
    mixinRouter,
} from '../mixes/injection';

const injection = {};

function install(instance) {
    Object.assign(injection, {
        http: instance.http,
        loading: instance.loading,
        message: instance.message,
        sidebar: instance.sidebar,
        trans: instance.trans,
    });
    mixinNavigation(instance);
    mixinRouter(instance);
}

export default Object.assign(injection, {
    install,
});
