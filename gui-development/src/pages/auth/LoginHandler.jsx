import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Center from "../../components/Center";
import useLoading from "../../hooks/useLoading";
import http from "../../util/http";

export default function LoginHandler({ children }) {
    const [isLoggedIn, setIsLoggedIn] = useState(true)
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();

    useLoading(loading);

    useEffect(() => {
        http
            .get('/user/me')
            .then(() => {
                navigate('/')
            })
            .catch(() => {
                setIsLoggedIn(false)
            })
            .finally(() => {
                setLoading(false)
            })
    }, [navigate])

    return !isLoggedIn &&
        <Center>
            {children}
        </Center>

}