import { useEffect } from "react";

export default function useLoading(state) {
    useEffect(() => {
        document.body.classList.toggle('loading', state);

        return () => document.body.classList.remove('loading');
    }, [state]);
}