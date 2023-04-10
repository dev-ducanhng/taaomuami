const token = await this.jwtService.signAsync(
      {
        iss: process.env.appotaPartnerCode,
        jti: process.env.appotaApiKey + '-' + new Date().getTime(),
        api_key: process.env.appotaApiKey,
      },
      {
        expiresIn: '10m',
        header: {
          alg: 'HS256',
          typ: 'JWT',
          cty: 'appotapay-api;v=1',
        },
        secret: process.env.appotaSecretKey,
      },
    );
    const order = await  this.orderTable.create({
      order:createVnpayDto.orderId,
      money: createVnpayDto.amount,
      status:PaymentStatus.CREATE
    })
    await this.orderTable.save(order)
    const dataSignature = `amount=${createVnpayDto.amount}&bankCode=&clientIp=${process.env.ip}&extraData=${createVnpayDto.orderId}&notifyUrl=${process.env.appotaIPNOrderUrl}&orderId=${order.id}&orderInfo=${createVnpayDto.orderId}&paymentMethod=&redirectUrl=${process.env.appotaReturnUrl}`;
    const hmac = CryptoJS.enc.Hex.stringify(
      CryptoJS.HmacSHA256(dataSignature, process.env.appotaSecretKey),
    );
    const requestConfig: AxiosRequestConfig = {
      headers: {
        'Content-Type': 'application/json',
        'X-APPOTAPAY-AUTH': `Bearer ${token}`,
      },
    };
    try {
      const body = {
        amount: createVnpayDto.amount,
        orderId: order.id,
        orderInfo: `${createVnpayDto.orderId}`,
        bankCode: '',
        paymentMethod: '',
        clientIp: process.env.ip,
        extraData: createVnpayDto.orderId,
        notifyUrl: process.env.appotaIPNOrderUrl,
        redirectUrl: process.env.appotaReturnUrl,
        signature: hmac,
      };
      const data = await lastValueFrom(
        this.httpService.post(
          this.configService.get('appotaUrl') + '/api/v1/orders/payment/bank',
          body,
          requestConfig,
        ),
      );
      return data.data;
    } catch (error) {
      throw new HttpException(error.response.data, error.response.status);
    }