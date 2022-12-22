import { useEffect } from "react";
import { useState } from "react"
import { useNavigate } from "react-router-dom";
import Sidebar from "../components/dashboard-parts/Sidebar";
import Topbar from "../components/dashboard-parts/Topbar";
import useLoading from "../hooks/useLoading";
import http from "../util/http";

export default function Dashboard({ children }) {
    const [userData, setUserData] = useState({});
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();
    useLoading(loading);

    useEffect(() => {
        http
            .get('/user/me')
            .then(res => {
                setUserData(res.data.data)
            })
            .catch(() => {
                navigate('/login')
            })
            .finally(() => {
                setLoading(false)
            })
    }, [navigate])

    return userData !== {} &&
        <div>
            <Topbar />
            <Sidebar />
            <main>
                {children}
            </main>
        </div>

}