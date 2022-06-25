import {reactive, toRefs} from "vue";

/**
 *
 * @param {string} url
 * @param defaultValue
 * @param {"GET","DELETE"} method
 */
export const useFetch = (url, defaultValue = [],method = "GET") => {
    const data = reactive({
        isLoading: true,
        isRefreshing: false,
        data: defaultValue,
        error: null,
    });
    const toggleLoading = (value, isRefresh = false) => {
        data.isLoading = value && !isRefresh;
        data.isRefreshing = value && isRefresh;
    }
    const fetchData = (isRefresh = false) => {
        if (data.isLoading && data.isRefreshing) {
            return;
        }
        toggleLoading(true, isRefresh);
        return fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(async (v) => {
            const respBody = (await v.json());
            const statusCode = v.status;
            if (v.ok) {
                data.data = respBody.data;
                data.error = null;
            } else if (statusCode === 404) {
                data.error = "Not found";
            } else {
                data.error = "Server error, please try again";
            }
        }).catch((err) => {
            console.log(err);
            data.error = "Server error, please try again"
        }).then((v) => {
            toggleLoading(false, isRefresh);
            return data.error == null;
        })
    }
    return {
        ...toRefs(data),
        fetchData
    }

};
