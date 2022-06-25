import {reactive, toRefs} from "vue";

/**
 * @param {string} url
 */
export const usePush = (url) => {
    const data = reactive({
        successful: true,
        isOngoing: false,
        data: [],
        error: "",
        errors: {}
    });
    const toggleLoading = (value) => {
        data.isOngoing = value;
    }
    /**
     *
     * @param body
     * @param  {"POST"|"PUSH","PATCH"} method
     * @returns {Promise<boolean>}
     */
    const pushData = (body, method= "POST") => {
        if (data.isOngoing) {
            return;
        }
        toggleLoading(true);
        return fetch(url, {
            method: method,
            body: JSON.stringify(body),
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
                data.errors = [];
                data.successful = true;
                return;
            }
            data.successful = false;
            if (statusCode === 422) {
                data.error = "Some field are invalid or missing";
                data.errors = respBody;
                console.log(respBody)
            }else{
                data.error =  "Server error, please try again";
                data.errors = [];
            }
        }).catch((err) => {
            console.log(err);
            data.error = "Server error, please try again"
        }).then((v) => {
            toggleLoading(false);
            return data.error == null;
        })
    }
    return {
        ...toRefs(data),
        pushData
    }
}
