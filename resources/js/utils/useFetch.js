import { reactive, toRefs } from "vue";
class FetchError extends Error {
    errors = [];
    constructor(message, errors = []) {
        super(message);
        this.errors = errors;
    }
}

/**
 * @param defaultValue
 */
export const useFetch = (defaultValue = null) => {
    const data = reactive({
        isLoading: false,
        data: defaultValue,
        error: null,
        errors: [],
    });
    const toggleLoading = (value) => {
        data.isLoading = value;
    };
    /**
     *
     * @param {Object} params
     * @param {string} params.url
     * @param {string} params.defaultData
     * @param {"POST"|"GET"|"PUT"|"DELETE"} params.method
     * @param {Object|Array} params.body
     *
     * @returns
     */
    const fetchData = ({ url, defaultData, method, body }) => {
        if (data != null) {
            data.data = defaultData;
        }
        if (data.isLoading) {
            return;
        }
        toggleLoading(true);
        return fetch(url, {
            method,
            body: body ? JSON.stringify(body) : body,
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        })
            .then(async (v) => {
                const body = await v.json().catch((err) => {
                    return {};
                });
                const statusCode = v.status;
                if (v.ok) {
                    const result = body.data
                    data.data = result;
                    data.error = null;
                    data.errors = [];
                    toggleLoading(false);
                    return result;
                }
                if (statusCode === 404) {
                    throw new FetchError("Not found");
                } else if (statusCode == 422) {
                    throw new FetchError(
                        "Some fields are missing or invalid",
                        body ?? []
                    );
                } else if (statusCode == 401) {
                    throw new FetchError("Unauthorized");
                } else {
                    throw new FetchError("Server error, please try again");
                }
            })
            .catch((err) => {
                data.error =
                    err instanceof FetchError
                        ? err.message
                        : "Something went wrong, please refresh and try again";
                data.errors = err instanceof FetchError ? err.errors : [];
                toggleLoading(false);
                throw err;
            });
    };
    return {
        ...toRefs(data),
        fetchData,
    };
};
