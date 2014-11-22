package org.apache.ws.axis2;

import java.rmi.RemoteException;

import org.apache.axis2.AxisFault;
import org.apache.ws.axis2.WebServiceLeiturasStub.Leituras;
import org.apache.ws.axis2.WebServiceLeiturasStub.LeiturasResponse;

public class ClienteWSLeituras {
	public static void main(String[] args) {
		try {
			WebServiceLeiturasStub stub = new WebServiceLeiturasStub();

			Leituras find = new Leituras();
			find.setQuantidadeRegistros(15);
			find.setDataHora("2014-09-05T22:16:23.862Z");
			LeiturasResponse res = stub.leituras(find);
			System.out.println(res.get_return());
		} catch (AxisFault e) {
			e.printStackTrace();
		} catch (RemoteException e) {
			e.printStackTrace();
		}
	}
}
